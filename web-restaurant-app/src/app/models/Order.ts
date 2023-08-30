export interface Order {
        id_orden?: number;
        fecha_orden?: Date;
        fecha_entrega?: Date;
        id_estado?: number;
        id_receta?: number;
        desc_estado?: {
            id_estado?: number;
            estado?: string;
            descripcion?: string;
        };
        desc_receta?: {
            id_receta?: number;
            nombre_receta?: string;
            id_estado?: number;
        }
    }