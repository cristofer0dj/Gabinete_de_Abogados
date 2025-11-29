import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListaAbogados } from './lista-abogados';

describe('ListaAbogados', () => {
  let component: ListaAbogados;
  let fixture: ComponentFixture<ListaAbogados>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ListaAbogados]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ListaAbogados);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
