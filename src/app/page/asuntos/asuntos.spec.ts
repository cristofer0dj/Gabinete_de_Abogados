import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Asuntos } from './asuntos';

describe('Asuntos', () => {
  let component: Asuntos;
  let fixture: ComponentFixture<Asuntos>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Asuntos]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Asuntos);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
