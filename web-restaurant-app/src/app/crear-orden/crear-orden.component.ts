import { Component } from '@angular/core';
import { DataServicesService } from '../shared/data-services.service';
import { HttpErrorResponse } from '@angular/common/http';
import { ResponseAPI } from '../models/ResponseAPI';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-crear-orden',
  templateUrl: './crear-orden.component.html',
  styleUrls: ['./crear-orden.component.css']
})
export class CrearOrdenComponent {

  constructor(
    private services: DataServicesService
  ) { }

  public onOrder() {
    this.services.setCreateOrder().subscribe(
      (response) => {
        Swal.fire(
          'Order: ',
          'Succes create order ',
          'success'
        )
      },
      (error: HttpErrorResponse) => {
        Swal.fire(
          'fails',
          'Fails create order!',
          'question'
        )
      }
    );
  }
}
