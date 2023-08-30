import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListadoOrdenesComponent } from './listado-ordenes.component';

describe('ListadoOrdenesComponent', () => {
  let component: ListadoOrdenesComponent;
  let fixture: ComponentFixture<ListadoOrdenesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListadoOrdenesComponent]
    });
    fixture = TestBed.createComponent(ListadoOrdenesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
