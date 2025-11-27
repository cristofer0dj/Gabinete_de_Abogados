import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormAsunto } from './form-asunto';

describe('FormAsunto', () => {
  let component: FormAsunto;
  let fixture: ComponentFixture<FormAsunto>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FormAsunto]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FormAsunto);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
