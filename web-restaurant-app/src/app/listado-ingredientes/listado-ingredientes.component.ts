import { Component } from '@angular/core';
import { DataServicesService } from '../shared/data-services.service';

@Component({
  selector: 'app-listado-ingredientes',
  templateUrl: './listado-ingredientes.component.html',
  styleUrls: ['./listado-ingredientes.component.css']
})
export class ListadoIngredientesComponent {

  public orders: Array<any> = [];
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
    this.services.getIngredients().subscribe({
      next: (v: any) => {
        if (Array.isArray(v.data)) {
          this.orders  = v.data as Array<any>;
        } else {
          console.error('Data is not in expected format');
        }
        this.estado = 'Todos los ingredientes'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }
}
