import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataServicesService {

  private API_ORDERS_URL    ='http://127.0.0.1:8001/api/v1/orders'
  private API_STATUS_URL    ='http://127.0.0.1:8000/api/v1/status'
  private API_INVENTORY_URL ='http://127.0.0.1:8003/api/v1/ingredients'
  constructor(
    private http:HttpClient
  ) {
  
  }

  private requestConfig(body: any){
    let headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': '', // Si se crear servicio de autenticacoin
    });
    return {params: body, headers: headers };

  }

  /**
   * Peticion de tipo get solicitada a la API remota
   * @param {*} params  Objeto con los parametros de la consulta
   * @returns Respuesta enviada desde la API error/json
   * @memberof DataService
   */
  private get(url: any = null, params: any = null) {
    let options = this.requestConfig(params);
    return this.http.get(url, options);
  }

  private post(url: any = null, params: any = null){
    let options = this.requestConfig(params);
    return this.http.post(url, options);
  }

  private put(url: any = null, params: any = null){
    let options = this.requestConfig(params);
    return this.http.put(url, null, options);
  }

  /**
   * Peticion que solicita estados
   * @param {*} params  Objeto con los parametros de la consulta
   * @returns Respuesta enviada desde la API error/json
   * @memberof DataService
   */
  public getEstados(id_estado: number = 0) {
    let url: String = (id_estado == 0) ? this.API_STATUS_URL : this.API_STATUS_URL+'/'+id_estado;
    return this.get(url);
  }

  /**
   * Peticion que solicita estados
   * @param {*} params  Objeto con los parametros de la consulta
   * @returns Respuesta enviada desde la API error/json
   * @memberof DataService
   */
  public setCreateOrder() {
    return this.post(this.API_ORDERS_URL);
  }

  public getOrders(id_order: number | null = null, id_estado: number | null = null){
    let url: string = this.API_ORDERS_URL;
    if (id_order != null) {
      url = this.API_ORDERS_URL + '/' + id_order;
    }

    if (id_estado != null) {
      url = this.API_ORDERS_URL + '/status/' + id_estado;
    }

    return this.get(url);
  }

  public getIngredients(id_ingrediente: number | null = null, id_estado: number | null = null){
    let url: string = this.API_INVENTORY_URL + '/inventory';

    if (id_ingrediente != null) {
      url = this.API_ORDERS_URL + '/inventory/' + id_ingrediente+'/show';
    }

    if (id_estado != null) {
      url = this.API_ORDERS_URL + '/inventory/' + id_ingrediente + '/status/' + id_estado;
    }

    return this.get(url);
  }

  public getBuysIngredients(){
    let url: string = this.API_INVENTORY_URL + '/buy';
    return this.get(url);
  }

  public getRecetasDetails(){
    return this.get(this.API_ORDERS_URL +'/recipes/ingredients');
  }
  
  public takeOrder(id_order: number | undefined){
    return this.put(this.API_ORDERS_URL+'/'+id_order);
  }
}
