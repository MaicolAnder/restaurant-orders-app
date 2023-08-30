import { Component } from '@angular/core';
import { DataServicesService } from '../shared/data-services.service';
import { Compras } from '../models/Compras';

@Component({
  selector: 'app-listado-compras',
  templateUrl: './listado-compras.component.html',
  styleUrls: ['./listado-compras.component.css']
})
export class ListadoComprasComponent {
  public orders: Array<Compras> = [];
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
    this.services.getBuysIngredients().subscribe({
      next: (v: any) => {
        try {
          this.orders  = v.data as Array<Compras>;
          console.log(this.orders)
        } catch (error) {
          console.log(error)  
        }
        this.estado = 'Todas las compras'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }
}
