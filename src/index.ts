import * as P$ from './prymePay/index'
import { ACTIONS_ACCOUNT } from './prymePay'
import { ACTIONS_RECORDS } from './prymePay'

window.addEventListener('DOMContentLoaded', ()=>{
    let p$ = new P$.Core({
        prepareActionSets : [ACTIONS_ACCOUNT, ACTIONS_RECORDS]
    })    
})
