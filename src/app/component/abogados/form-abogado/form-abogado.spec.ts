import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormAbogado } from './form-abogado';

describe('FormAbogado', () => {
  let component: FormAbogado;
  let fixture: ComponentFixture<FormAbogado>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FormAbogado]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FormAbogado);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
