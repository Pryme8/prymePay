import { IActionData } from '../IActionData'
import { ActionSet } from '../actionSet'
import { RecordManager } from '../../recordManager'
import * as utilities from '../../utilities/index'

export const ACTIONS_RECORDS: ActionSet = [
    {
       name: "Records.LOAD",
        callback:function(actionData:IActionData): void{
            let target = document.getElementById('current-account-select') as HTMLSelectElement
            this.query("GET", 'accounts/records/all', {id:target.options[target.selectedIndex].value}, 
            (results:any)=>{
                console.log(results)
                if(results.responseType == "Success"){
                    this.recordManager = new RecordManager({
                        attachedDomElement: actionData.event.target,
                        structure:[
                            { name:'date', label:'Date', default:utilities.getNowDateInputValue, type:'date', required: true, sorting:{
                                enabled: true,
                                active: true,
                                direction: RecordManager.SORT_DESC
                            }},
                            { name:'startedOn', default:null, type:'time', typeAttributes:{step:1800}, required: true },
                            { name:'endedOn', default:null, type:'time', typeAttributes:{step:1800}, required: true },
                            { name:'rate', default:'30.00', type:'money', required: true },
                            { name:'discount', default:'0.00', type:'money' },
                            { name:'description', default:'', type:'description', required: false, sterilize:true }   
                        ]
                    }, results.data)
                    console.log(this.recordManager)
                }                        
            }, 
            (error:any)=>{
                console.log(error)
            }) 
        }
    },
    {
        name: "Records.DELETE",
         callback:function(actionData:IActionData): void{
            if(!confirm("Are you sure you want to archive this record?")){
                return
            }
            let id = actionData.event.target.getAttribute('record-id')
            if(id!=-1){  
            this.query("GET", 'accounts/records/delete', {id:actionData.event.target.getAttribute('record-id')}, 
            (results:any)=>{
                console.log(results)
                if(results.responseType == "Success"){
                    console.log("Delete:", actionData.event.target.getAttribute('record-id'))
                    this.recordManager.delete(actionData.event.target.getAttribute('record-index'))           
                }                        
            }, 
            (error:any)=>{
                console.log(error)
            })
            }else{
                this.getParentNodeByClass(actionData.event.target, 'record-item').remove()
            }              
        }
    },
    {
        name: "Records.SAVE",
         callback:function(actionData:IActionData): void{
            let select = document.getElementById('current-account-select') as HTMLSelectElement
            let data: any = {
                accountId: select.options[select.selectedIndex].value
            }
            let item = this.getParentNodeByClass(actionData.event.target, 'record-item')
            let dirtyForm = this.getFormData(item)
            let form = this.recordManager.prepFormData(dirtyForm)
            let formOk =  this.recordManager.checkFormData( form )                
            if(!formOk){
                console.log("Check form Data!", form)
                return
            }
            data.recordData = JSON.stringify(form)
            this.fetchQuery("POST", 'accounts/records/new', data, 
            (results:any)=>{
                console.log(results)
                if(results.responseType == "Success"){                       
                    item.querySelectorAll('input, textarea').forEach((i:any)=>{
                        i.setAttribute('id', results.newRecordId)
                        i.setAttribute('change-action', 'Records.UPDATE')
                    })
                    let menu = item.querySelector('span.record-item-menu')
                    console.log(menu.children)
                    menu.childNodes[0].remove()
                    menu.childNodes[0].remove()
                    menu.childNodes[0].setAttribute('record-id', results.newRecordId)
                    menu.childNodes[0].setAttribute('record-index', this.recordManager.records.length)
                    this.recordManager.records.push({recordData:dirtyForm})
                }                        
            }, 
            (error:any)=>{
                console.log(error)
            })     
        }
    },
    {
        name: "Records.UPDATE",
         callback:function(actionData:IActionData): void{
            let field = actionData.event.target
            let item = this.getParentNodeByClass(field, 'record-item')

            item.classList.add('locked')
           
            let data: any = {
                id : field.getAttribute('id')
            }
         
            let dirtyForm = this.getFormData(item)
            let form = this.recordManager.prepFormData(dirtyForm)
            let formOk =  this.recordManager.checkFormData( form )                
            if(!formOk){
                console.log("Check form Data!", form)
                return
            }
            data.recordData = JSON.stringify(form) 
            this.fetchQuery("POST", 'accounts/records/update', data, 
            (results: any)=>{
                console.log(results)
                if(results.responseType == "Success"){                       
                    item.classList.remove('locked')
                }                        
            }, 
            (error: any)=>{
                console.log(error)
            })
        } 
    },
    {
        name: "Records.NEW_ITEM",
        callback:function(actionData:IActionData): void{
            console.log(actionData)
            this.recordManager.addNewItem()
        }
    }    
]