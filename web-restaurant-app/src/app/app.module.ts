import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { CrearOrdenComponent } from './crear-orden/crear-orden.component';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ListadoComprasComponent } from './listado-compras/listado-compras.component';
import { ListadoOrdenesComponent } from './listado-ordenes/listado-ordenes.component';
import { ListadoIngredientesComponent } from './listado-ingredientes/listado-ingredientes.component';
import { ListadoRecetasComponent } from './listado-recetas/listado-recetas.component';
import { DataTablesModule } from 'angular-datatables';


@NgModule({
  declarations: [
    AppComponent,
    CrearOrdenComponent,
    ListadoComprasComponent,
    ListadoOrdenesComponent,
    ListadoIngredientesComponent,
    ListadoRecetasComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    DataTablesModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
