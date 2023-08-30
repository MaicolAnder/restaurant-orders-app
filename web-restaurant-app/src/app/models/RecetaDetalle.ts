export interface RecetaDetalle {
    id_receta?: number;
    nombre_receta?: string;
    id_estado?: number;
    ingredientes?: Array<Ingrediente>;
}

export interface Ingrediente {
        id_ingre_receta?: number;
        cantidad_requerida?: number;
        id_ingrediente?: number;
        id_receta?: number;
        nombre?: string;
}