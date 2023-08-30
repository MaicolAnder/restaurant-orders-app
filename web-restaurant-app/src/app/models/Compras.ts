export interface Compras {
    id_solicitud?: number;
    cantidad?: number;
    costo?: number;
    fecha_registro?: Date;
    tipo_movimiento?: string;
    id_ingrediente?: number;
    ingrediente?: {
        id_ingrediente?: number;
        nombre_ingrediente?: string;
        id_estado?: number;
    }
}