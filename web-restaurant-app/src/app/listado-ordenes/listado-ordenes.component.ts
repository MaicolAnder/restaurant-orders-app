import { Component } from '@angular/core';
import { DataServicesService } from '../shared/data-services.service';
import { Order } from '../models/Order';

@Component({
  selector: 'app-listado-ordenes',
  templateUrl: './listado-ordenes.component.html',
  styleUrls: ['./listado-ordenes.component.css']
})
export class ListadoOrdenesComponent {
  public orders: Array<Order> = [];
  public estado: string = 'Cargando datos ...';

  constructor(
    private services: DataServicesService
  ){ 
    this.getOrdersOnPreparationStatus();
  }

  takeOrder(id: number | undefined){
    this.estado = 'Tomando Orden ...';
    this.services.takeOrder(id).subscribe({
      next: (v: any) => {
        this.estado = 'Orden en proceso de preparación';
        if(v.data.id_estado == 2){
          this.getOrdersNew()
        }
        if(v.data.id_estado == 3){
          this.getOrdersOnPreparationStatus()
        }
      },
      error: (e) => console.error(e),
      complete: () => console.log('Complete'),
    })
  }

  /**
   * Get all Orders 
   */
  getAllOrders() {
    this.estado = 'Cargando datos ...';
    this.services.getOrders().subscribe({
      next: (v: any) => {
        if (Array.isArray(v.data)) {
          this.orders  = v.data as Array<Order>;
        } else {
          console.error('Data is not in expected format');
        }
        this.estado = 'Todas las ordenes'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }

  getOrdersOnPreparationStatus() {    
    this.estado = 'Cargando datos ...';
    this.services.getOrders(null, 2).subscribe({
      next: (v: any) => {
        if (Array.isArray(v.data)) {
          this.orders  = v.data as Array<Order>;
        } else {
          console.error('Data is not in expected format');
        }
        this.estado = 'Ordenes en preparación'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }

  getOrdersOnDeliveryStatus(){
    this.estado = 'Cargando datos ...';
    this.services.getOrders(null, 3).subscribe({
      next: (v: any) => {
        if (Array.isArray(v.data)) {
          this.orders  = v.data as Array<Order>;
        } else {
          console.error('Data is not in expected format');
        }
        this.estado = 'Histórico de ordenes'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }

  getOrdersNew(){
    this.estado = 'Cargando datos ...';
    this.services.getOrders(null, 1).subscribe({
      next: (v: any) => {
        if (Array.isArray(v.data)) {
          this.orders  = v.data as Array<Order>;
        } else {
          console.error('Data is not in expected format');
        }
        this.estado = 'Ordenes pendientes'
      },
      error: (e) => console.error(e),
      complete: () => console.info('complete')
    })
  }
}
