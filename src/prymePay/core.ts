import { ActionSet } from './actions/index'
import { ACTIONS_DEFAULT } from './actions/index'
import { RecordManager } from './recordManager';

export interface ICoreParams{
    domTarget?: string | HTMLElement,
    prepareActionSets?: ActionSet[]
}

export class Core{
    public params: ICoreParams;

    private _actionCache: any;
    public templateCache: any;

    public recordManager: RecordManager;

    constructor(params: ICoreParams){        
        params.domTarget = (params.domTarget instanceof HTMLElement)?params.domTarget:document.getElementById(params.domTarget) || document.body
        params.prepareActionSets = params.prepareActionSets || []
        params.prepareActionSets.push(ACTIONS_DEFAULT)

        this.params = params
        this._actionCache = {}
        this.templateCache = {} 
        this._actionBindings()
        this.params.prepareActionSets.forEach(set=>{
            this.cacheActions(set)
        })
        this._runLoadActions()
        this.recordManager = null
        console.log(this)
    }

    private _actionBindings(): void {
        let actionTypes = ['change', 'click']
        if(this.params.domTarget){
            actionTypes.forEach( type =>{
                (this.params.domTarget as HTMLElement).addEventListener(type, (event)=>{
                    this._action(type, event)
                })
            })
        }
    }

    private _action(type: string, event: any): void {
        if(event.target && event.target.getAttribute(type+"-action")){
            let callbackKey = event.target.getAttribute(type+"-action")
            if(callbackKey && this._actionCache[callbackKey]){
                this._actionCache[callbackKey]({type, event})
            }
        }
    }

    public addAction(name: string, callback: void): void {
        this._actionCache[name] = callback
    }

    private _runLoadActions(): void {
        document.querySelectorAll('*[load-action]').forEach((target)=>{
            let callbackKey = target.getAttribute("load-action")
            target.removeAttribute("load-action")
            if(callbackKey && this._actionCache[callbackKey]){
                this._actionCache[callbackKey]({type:'load-action', event:{target}})
            }
        })
    }
        
    public cacheActions(actions: ActionSet): void{
        actions.forEach( action =>{
            if(!this._actionCache[action.name]){
                this._actionCache[action.name] = action.callback.bind(this)
            }else{
                console.log(action.name, "Already Exists!")
            }
        })       
    }
        
    getParentNodeByClass(target: Node, selector: string): Node{
        let p = null 
        while(p == null && target != document.body && target.parentNode){                 
            let _p = target.parentNode
            if((_p as Element).classList.contains(selector)){
                p = _p
            }else{
                target = _p
            }
        }
        return p
    }
        
    manualAction(name: string, event: any): void{
        if(this._actionCache[name]){
            this._actionCache[name]({type:'manual-action', event})
        }
    }
        
    getFormData(target: string|Element) : any{
        target = document.getElementById(target as string) || target
        if(!target){
            return false
        }

        let data: any = {};

        (target as any).querySelectorAll('input, textarea').forEach(
            (el:any)=>{
                console.log(el.getAttribute('fieldId'))
                data[el.getAttribute('fieldId')] = el.value || el.getAttribute('value') || null
            }
        )                        
        console.log(data, target)
        return data
    }
        
    fetchQuery(type: string, process: string, data: any = null, onSuccess: Function = null, onError: Function = null): void{                 
        let url = './process/'+((type=="POST")?'post/':'get/')+process+'.php'
        fetch(url, 
        {
            method : type,
            body: JSON.stringify(data),
        }).then((response)=>{
            if(onSuccess){
                response.json().then((json)=>{
                    onSuccess(json)
                })                    
            }
        }
        ).catch((error)=>{
            if(onError){
                onError(error)
            }
        })
    }
        
    query(type: string, process: string, params: any = null, onSuccess: Function = null, onError: Function = null): void{ 
        var xmlhttp = new XMLHttpRequest()
        xmlhttp.onreadystatechange = ()=>{
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {   
                if (xmlhttp.status == 200) {
                    if(onSuccess){
                        let response = JSON.parse(xmlhttp.responseText)
                        if(response.data){
                            response.data.forEach((r:string, i:number)=>{
                                for (const [key, value] of Object.entries(r)) {
                                    let v;
                                    try {
                                        v = JSON.parse(value as string);
                                    } catch (e) {                                      
                                        v = value;
                                    }
                                    response.data[i][key] = v;
                                } 
                            })                                
                        }
                        onSuccess(response)
                    }                      
                }
                else if (xmlhttp.status == 400) {
                    console.log('There was an error 400')
                }
                else {
                    console.log('something else other than 200 was returned')
                }
            }
        }
        let url = './process/'+((type=="POST")?'post/':'get/')+process+'.php'
        if(type==='GET' && params){
            url+="?"  
            for (const [key, value] of Object.entries(params)) {
                url+=`${key}=${value}&`
            }
            url = url.substr(0, url.length-1)
        }
        xmlhttp.open(type, url, true)
        xmlhttp.send((type==='POST')?JSON.stringify(params):null)         
    }
        
    loadTemplate(template: string, data: any, target: HTMLElement, append: boolean = false){
        var xmlhttp = new XMLHttpRequest()
        xmlhttp.onreadystatechange = ()=>{
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {   
                if (xmlhttp.status == 200) {
                    if(!append){
                        target.innerHTML = xmlhttp.responseText
                    }else{
                        target.innerHTML += xmlhttp.responseText
                    }
                    this._runLoadActions()                    
                }
                else if (xmlhttp.status == 400) {
                    console.log('There was an error 400')
                }
                else {
                    console.log('something else other than 200 was returned')
                }
            }
        }
        let url = './templates/'+template+'.php'    
        url+="?" 
        if(data){    
            for (const [key, value] of Object.entries(data)) {  
                url+=`${key}=${value}&`
            }
        }
        url = url.substr(0, url.length-1)
        xmlhttp.open("GET", url, true)
        xmlhttp.send()
    }
}










