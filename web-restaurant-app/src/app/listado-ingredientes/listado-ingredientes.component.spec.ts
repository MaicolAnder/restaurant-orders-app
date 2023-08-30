import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListadoIngredientesComponent } from './listado-ingredientes.component';

describe('ListadoIngredientesComponent', () => {
  let component: ListadoIngredientesComponent;
  let fixture: ComponentFixture<ListadoIngredientesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListadoIngredientesComponent]
    });
    fixture = TestBed.createComponent(ListadoIngredientesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
