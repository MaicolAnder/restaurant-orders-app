import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListadoRecetasComponent } from './listado-recetas.component';

describe('ListadoRecetasComponent', () => {
  let component: ListadoRecetasComponent;
  let fixture: ComponentFixture<ListadoRecetasComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListadoRecetasComponent]
    });
    fixture = TestBed.createComponent(ListadoRecetasComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
