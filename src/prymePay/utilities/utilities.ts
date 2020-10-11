
(Date as any).prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset())
    return local.toJSON().slice(0,10)
})

export const getNowDateInputValue = ()=>{
    let date = new Date()
    return (date as any).toDateInputValue()
}

export const isFunction = (functionToCheck:any) =>{
    return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
}

export const escapeHtml = (text:string) =>{
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }  
    return text.replace(/[&<>"']/g, function(m) { return (map as any)[m]; })
}