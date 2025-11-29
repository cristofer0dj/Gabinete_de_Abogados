import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AsignarAbogados } from './asignar-abogados';

describe('AsignarAbogados', () => {
  let component: AsignarAbogados;
  let fixture: ComponentFixture<AsignarAbogados>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AsignarAbogados]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AsignarAbogados);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
