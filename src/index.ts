import * as P$ from './prymePay/index'
import { ACTIONS_ACCOUNT, ACTIONS_RECORDS, ACTIONS_SORTING } from './prymePay'

window.addEventListener('DOMContentLoaded', ()=>{
    let p$ = new P$.Core({
        prepareActionSets : [ACTIONS_ACCOUNT, ACTIONS_RECORDS, ACTIONS_SORTING]
    })    
})
