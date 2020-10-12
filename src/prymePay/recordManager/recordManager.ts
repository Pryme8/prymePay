import { RecordManagerStructure } from './structure'
import * as utilities from '../utilities/index'

export interface IRecordManagerParams{
    structure:RecordManagerStructure
    attachedDomElement?: HTMLElement
}

export class RecordManager{

    static SORT_DESC: number = 0
    static SORT_ASCE: number = 0

    static SortingTypes = {
        DATE_ASCENDING  : (a:any, b:any)=>{ return (new Date(a.recordData.date)).valueOf() - (new Date(b.recordData.date)).valueOf() },
        DATE_DESCENDING : (a:any, b:any)=>{ return (new Date(b.recordData.date)).valueOf() - (new Date(a.recordData.date)).valueOf() }
    }

    static TypeConversion = (type:string)=>{
        switch(type){
            case 'money':
                return 'number'
            default:
                return type
        }
    }

    static GetDefaultSortingTypes = (type:string)=>{
        switch(type){
            case 'date':
                return [ RecordManager.SortingTypes.DATE_DESCENDING, RecordManager.SortingTypes.DATE_ASCENDING ]            
        }
    }

    // static TestRegexType = (value)=>{
    //     console.log(value)
    //     let date = RegExp('^20[0-9]{2}-[0-1][0-2]-[0-3]?[0-9]');
    //     console.log(date.test(value))
    //     if(date.test(value)){
    //         return 'date'
    //     }
    //     let money = RegExp('^\d+(?:\.\d{0,2})?$');
    //     if(money.test(value) || value === 0){
    //         return 'money'
    //     }
    //     let time = RegExp('[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}');
    //     if(time.test(value)){
    //         return 'time'
    //     }      

    //     return 'text'
    // }
    public params: IRecordManagerParams
    public records: any
    public structure: RecordManagerStructure
    public attachedDomElement?: HTMLElement
    public list?: HTMLElement

    constructor(params: IRecordManagerParams, records:any){
        this.params = params
        this.records = records
        this.structure = params.structure 

        this.structure.forEach(s=>{
            if(s.sorting?.enabled && s.sorting?.active){
                if(s.sorting.customFunctions){
                    this.sort((s.sorting.direction)?s.sorting.customFunctions.descending : s.sorting.customFunctions.ascending)
                }else{
                    this.sort(RecordManager.GetDefaultSortingTypes(s.type)[s.sorting.direction])
                }
            }
        })

        this.attachedDomElement = params.attachedDomElement || null
        this.list = null;
        if(this.attachedDomElement){
            this.updateHtml()
        }
    }   

    sort(type: Function){
        console.log('sorting!')   
        return this.records.sort(type)
    }
    
    delete(index: number){
        this.updateHtml()
    }

    updateHtml(){
        let list = this.list = document.createElement('div')
        list.classList.add('record-list')
        list.appendChild(this._generateItemHead())
        this.records.forEach((r:any, i:number) => {
            list.appendChild(this._generateItem(r, i, r.id))
        })
        this.attachedDomElement.innerHTML = ''
        this.attachedDomElement.appendChild(list)
    }

    addNewItem(){
        this.list.appendChild(this._generateItem(null))
    }

    checkFormData(form:any){
        let formOk = true
        this.structure.forEach(s => {
            if(s.required){                    
                if(s.type !== 'description'){
                    if(!form[s.name]){
                        formOk = false                                
                    }
                }else{
                    if(form[s.name] === undefined){
                        formOk = false                                
                    }
                }
            }
            return formOk
        })
        return formOk                
    }

    prepFormData(form:any){            
        this.structure.forEach(s =>{  
            if(form[s.name]){
                switch(s.type){
                    case 'money':
                    let noPeriod = RegExp('\.{1}');
                        if(!noPeriod.test(form[s.name])){
                            form[s.name]+='.00'
                        }
                    break;
                }
            }else{
                switch(s.type){
                    case 'money':
                        form[s.name] = "0.00"
                    break;
                }
            }
            if(s.sterilize || s.type == 'description'){
                form[s.name] = encodeURIComponent(utilities.escapeHtml(form[s.name]))
            }
        })
        return form
    }


    _generateItemHead(){
        let itemHead = document.createElement('div')
        itemHead.classList.add('record-item-header')
        let head = document.createElement('span')
        head.classList.add('record-item-head')
        head.innerHTML = 'record #'
        itemHead.appendChild(head)

        this.structure.forEach(s=>{
            head = document.createElement('span')
            head.classList.add('record-item-head')
            head.setAttribute('id', s.name+'-header')             
            if(s.sorting?.enabled){
                itemHead.classList.add('sortable', (s.sorting.direction)?'descending':'ascending')
                let link = document.createElement('a')
                link.setAttribute('href', '#')
                link.innerHTML = s.label || s.name
                head.appendChild(link)
            }else{
                head.innerHTML = s.label || s.name
            }        
            itemHead.appendChild(head)           
        })

        head = document.createElement('span')
        head.classList.add('record-item-head')
        head.innerHTML = 'record menu'
        itemHead.appendChild(head)

        return itemHead          
    }
    
    _generateItem(record:any, index= -1, skipMenu = false, skipKey = true){

        let item = document.createElement('div')
        item.classList.add('record-item')
        item.setAttribute('id', (index>=0)?'item-'+index:'item-new')
        let itemId = document.createElement('span')
        itemId.classList.add('record-item-id')
        itemId.innerHTML = (index>=0)?index+'':''
        item.appendChild(itemId)

        this.structure.forEach(s=>{
            let field = document.createElement('span')
            field.classList.add('record-item-field')
            
            if(!skipKey){
                let fKey = document.createElement('span') 
                fKey.classList.add('record-item-field-key')              
                fKey.innerHTML = s.label || s.name
                field.appendChild(fKey)                
            }

            if(s.type == "description"){
                let fValue = document.createElement('textarea')
                fValue.classList.add('record-item-field-value')
                let id = (record)?record.id:'new'
                fValue.setAttribute('id', id)
                fValue.setAttribute('fieldId', s.name)
                fValue.setAttribute('rows', '2')
                fValue.setAttribute('cols', '60')

                if(record){
                    fValue.setAttribute('change-action', 'Records.UPDATE')
                }
                
                if(index>=0){
                    let value = record.recordData[s.name] || '';
                    fValue.innerHTML = decodeURIComponent(value.replace(/\+/g, ' '))
                }

                if(s.typeAttributes){
                    for (const [key, value] of Object.entries(s.typeAttributes)) {  
                        fValue.setAttribute(key, value+'')
                    }
                }
                field.appendChild(fValue)
            } else{
                let fValue: HTMLInputElement = document.createElement('input')
                fValue.classList.add('record-item-field-value')
                let id = (record)?record.id:'new'
                fValue.setAttribute('id',id)
                fValue.setAttribute('fieldId', s.name)
                if(record){
                    fValue.setAttribute('change-action', 'Records.UPDATE')
                }
                if(record){
                    console.log(record.recordData)
                    fValue.setAttribute('value', record.recordData[s.name])
                    fValue.value = record.recordData[s.name]
                }else{
                    if(s.default !== null || s.default !== undefined){
                        let v = s.default
                        if(v instanceof Function){
                            v = s.default()
                        }
                        fValue.setAttribute('value', v)
                        fValue.value = v
                    }
                }            
                
                let type = s.type
                if( type == "money" ){  
                    fValue.setAttribute('min', '0.01')
                    fValue.setAttribute('step','0.01')
                }
                fValue.setAttribute('type', RecordManager.TypeConversion(s.type))
                if(s.typeAttributes){
                    for (const [key, value] of Object.entries(s.typeAttributes)) {  
                        fValue.setAttribute(key, value+'')
                    }
                }
                field.appendChild(fValue)
            }
            item.appendChild(field) 
        })
        
        let field = document.createElement('span')
        field.classList.add('record-item-menu')

        if(!record){
            let save = document.createElement('a')
            save.setAttribute('href', '#')
            save.setAttribute('click-action', 'Records.SAVE')
            save.setAttribute('record-id', 'new')
            save.setAttribute('record-index', 'new')
            save.innerHTML = 'save'
            field.appendChild(save)

            let spacer = document.createElement('span')
            spacer.innerHTML = ' | '
            field.appendChild(spacer)
        }
        let del = document.createElement('a')
        del.setAttribute('href', '#')
        del.innerHTML = 'delete'
        del.setAttribute('click-action', 'Records.DELETE')
        del.setAttribute('record-id', (record)?record.id:'new')
        del.setAttribute('record-index', index+'')
        field.appendChild(del)
        item.appendChild(field)
        return item
    }
}