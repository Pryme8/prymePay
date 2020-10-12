import { IActionData } from '../IActionData'
import { ActionSet } from '../actionSet'
import { IRecordManagerStructureItem, RecordManager } from '../../recordManager'

export const ACTIONS_SORTING: ActionSet = [
    {
        name: "Sorting.TOGGLE_HEADER",
        callback:function(actionData:IActionData): void{
            console.log(actionData)

            let structure: IRecordManagerStructureItem = this.recordManager.structure[
                actionData.event.target.getAttribute('s-id')
            ]

            let direction = 1
            if(actionData.event.target.parentNode.classList.contains('descending')){
                direction = 0                
            }
            actionData.event.target.parentNode.classList.toggle('descending')
            actionData.event.target.parentNode.classList.toggle('ascending')

            this.recordManager.structure.forEach((s: IRecordManagerStructureItem)=>{
                if(s.sorting){s.sorting.active = false}
            })
            structure.sorting.active = true
            let sorting = (structure.sorting.customFunctions)?(direction)?'descending':'ascending':RecordManager.GetDefaultSortingTypes(structure.type)[direction]
    
            this.recordManager.sort(sorting)
            this.recordManager.updateHtml()
        }
    }
]