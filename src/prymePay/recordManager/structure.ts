import { RecordManager } from './'

export interface IRecordManagerSortingSet{
    ascending: Function
    descending: Function
}

export interface IRecordManagerSortingOptions{
    enabled: boolean
    active: boolean
    direction: number
    customFunctions?: IRecordManagerSortingSet
}

export interface IRecordManagerStructureItem{
    name: string
    type: string
    /** The value the item at initialization */
    default: any
    label?: string
    required?: boolean
    /** Auto sterilize the string */
    sterilize?: boolean
    /** HTMLElements attributes to add */
    typeAttributes?: any
    /** Custom Sorting Functions */
    sorting?: IRecordManagerSortingOptions
}

export type RecordManagerStructure = IRecordManagerStructureItem[]