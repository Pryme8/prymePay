import { IActionData } from '../IActionData'
import { ActionSet } from '../actionSet'

export const ACTIONS_ACCOUNT: ActionSet = 
    [
        {
           name: "Account-Select.CHANGE",
           callback:function(actionData:IActionData): void{
                console.log(actionData)
                this.query('GET', 'accounts/names', {id:actionData.event.target.options[actionData.event.target.selectedIndex].value}, (nameResponse:any)=>{
                    console.log(nameResponse)
                    if(nameResponse.responseType == "Success"){
                        let content = document.getElementById('content')
                        console.log(content)
                        this.loadTemplate('account/info', nameResponse.data[0], content)                                               
                    }
                })
            }
        },
        {
            name: "Account-Select.LOAD",
            callback:function(actionData:IActionData): void{
                 console.log(actionData, this)
                 this.query('GET', 'accounts/all', null, (response: any)=>{
                     if(response.data){                 
                         response.data.forEach((row:any)=>{
                             let option = document.createElement('option')
                             option.setAttribute('value', row.id)
                             option.innerHTML = row.accountName
                             console.log(actionData.event)
                             actionData.event.target.appendChild(option)
                         })
                     }
                     this.manualAction('Account-Select.CHANGE', actionData.event)
                 })
             }
        },
        {
            name: "Account-Address.LOAD",
            callback:function(actionData:IActionData): void{
                console.log(actionData)
                let target = (document.getElementById('current-account-select') as HTMLSelectElement) 
                this.query('GET', 'accounts/data', {id:target.options[target.selectedIndex].value}, (response:any)=>{
                    console.log(response)
                    if(response.responseType == "Success"){
                        let data:any = {id:response.data[0].id};
                        for (const [key, value] of Object.entries(response.data[0].accountData)) {
                            data[key] = value
                        }
                        this.loadTemplate('account/address', data, actionData.event.target)
                    }
                })
            }
        },
        {
            name: "Account-New.START",
            callback:function(actionData:IActionData): void{
                console.log(actionData)
                let popup = document.createElement('div')
                popup.classList.add('popup')
                this.loadTemplate('account/new', null, popup)
                document.getElementById('content').appendChild(popup)
            }
        },
        {
            name: "Account-New.ACCEPT",
            callback:function(actionData:IActionData): void{
                console.log(actionData)
                let data = {
                        names : this.getFormData('new-account-names-form'),
                        other :this.getFormData('new-account-other-form')
                    }
                if(data){
                    this.fetchQuery("POST", 'accounts/new', data, 
                    (results:any)=>{
                        console.log(results)
                        if(results.responseType == "Success"){
                            this.manualAction('Close-Parent-Popup', actionData.event)
                        }                        
                    }, 
                    (error:any)=>{
                        console.log(error)
                    })
                }       
            }
        }
    ]
    
