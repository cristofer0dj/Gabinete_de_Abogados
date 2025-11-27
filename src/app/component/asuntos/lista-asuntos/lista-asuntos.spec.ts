import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListaAsuntos } from './lista-asuntos';

describe('ListaAsuntos', () => {
  let component: ListaAsuntos;
  let fixture: ComponentFixture<ListaAsuntos>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ListaAsuntos]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ListaAsuntos);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
