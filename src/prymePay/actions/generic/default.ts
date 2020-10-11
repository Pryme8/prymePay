import { IActionData } from '../IActionData'
import { ActionSet } from '../actionSet'

export const ACTIONS_DEFAULT: ActionSet = [
    {
       name: "Close-Parent-Popup",
        callback:function(actionData:IActionData): void{
            console.log(actionData)
            let t = actionData.event.target
            let p = null
            console.log(t, t.parentNode)
            while(p == null && t != document.body && t.parentNode){                 
                let _p = t.parentNode
                if(_p.classList.contains('popup')){
                    p = _p
                }else{
                    t = _p
                }
            }
            if(p){
                p.remove()
            }          
        }
    }
]
