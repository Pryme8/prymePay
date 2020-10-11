export interface IRecordManagerStructureItem{
    name: string;
    type: string;
    default: any; 
    label?: string;
    required?: boolean;
    sterilize?: boolean;
    typeAttributes?:any;
}
export type RecordManagerStructure = IRecordManagerStructureItem[]