import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CrearOrdenComponent } from './crear-orden/crear-orden.component';
import { ListadoOrdenesComponent } from './listado-ordenes/listado-ordenes.component';
import { ListadoComprasComponent } from './listado-compras/listado-compras.component';
import { ListadoIngredientesComponent } from './listado-ingredientes/listado-ingredientes.component';
import { ListadoRecetasComponent } from './listado-recetas/listado-recetas.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: '/crear-orden',
    pathMatch: 'full',
  },
  {
    path: '',
    children: [
      { path: '', component: CrearOrdenComponent },
      { path: 'crear-orden', component: CrearOrdenComponent },
      { path: 'listado-orden', component: ListadoOrdenesComponent },
      { path: 'listado-compras', component: ListadoComprasComponent },
      { path: 'listado-ingredientes', component: ListadoIngredientesComponent },
      { path: 'listado-recetas', component: ListadoRecetasComponent },
      { path: '**', component: CrearOrdenComponent }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
