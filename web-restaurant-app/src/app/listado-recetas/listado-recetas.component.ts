import { Component } from '@angular/core';
import { DataServicesService } from '../shared/data-services.service';
import { Ingrediente, RecetaDetalle } from '../models/RecetaDetalle';

@Component({
  selector: 'app-listado-recetas',
  templateUrl: './listado-recetas.component.html',
  styleUrls: ['./listado-recetas.component.css']
})
export class ListadoRecetasComponent {
  public orders: Array<RecetaDetalle> = [];
  public ingredients?: Array<Ingrediente> = [];
  public receta?: string = '';
  public estado: string = 'Cargando datos ...';

  constructor(
    private services: DataServicesService
  ){ 
    this.getAll();
  }

  /**
   * Get all Orders 
   */
  getAll() {
    this.estado = 'Cargando datos ...';
    this.services.getRecetasDetails().subscribe({
      next: (v: any) => {
        try {
          this.orders  = v.data as Array<RecetaDetalle>;
        } catch (error) {
          console.log(error)  
        }
        this.estado = 'Todas las recetas'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }

  details(id_receta: number | undefined): Array<Ingrediente>{
    let detail = this.orders.find( r => r.id_receta == id_receta)
    if(detail){
      this.ingredients = detail.ingredientes;
      this.receta = detail.nombre_receta
    }
    return [];
  }
}
