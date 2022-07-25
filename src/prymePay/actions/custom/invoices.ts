import { IActionData } from '../IActionData'
import { ActionSet } from '../actionSet'
import { IRecordManagerStructureItem, RecordManager } from '../../recordManager'

export const ACTIONS_INVOICE: ActionSet = [
    {
        name: "Invoice.SAVE",
        callback:function(actionData:IActionData): void{
            console.log(actionData)
            this.fetchQuery('POST', 'invoices/save', {
                accountId:actionData.event.target.getAttribute('account-id'),
                paramsString:actionData.event.target.getAttribute('params-string')
            })
        }
    }
]