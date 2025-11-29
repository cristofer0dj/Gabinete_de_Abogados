
import { Component, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-form-abogado',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './form-abogado.html',
  styleUrls: ['./form-abogado.css'],
})
export class FormAbogado {
  @Output() accionRealizada = new EventEmitter<any>();

  nombre: string = '';
  apellido: string = '';
  telefono: string = '';
  email: string = '';
  mensaje: string = '';
  loading: boolean = false;

  constructor(private apiService: ApiServiceTs) {}

  guardar() {
    this.loading = true;
    this.mensaje = '';

    if (!this.nombre || !this.apellido || !this.email) {
      this.mensaje = 'Nombre, apellido y email son obligatorios';
      this.loading = false;
      return;
    }

    const datos = {
      nombre: this.nombre,
      apellido: this.apellido,
      telefono: this.telefono,
      email: this.email,
    };

    this.apiService.crearAbogado(datos).subscribe({
      next: (res) => {
        console.log('Abogado creado:', res);
        this.mensaje = 'Abogado creado exitosamente!';
        this.loading = false;
        // limpiar
        this.nombre = '';
        this.apellido = '';
        this.telefono = '';
        this.email = '';
        setTimeout(() => this.accionRealizada.emit(1), 1000);
      },
      error: (err) => {
        console.error('Error creando abogado:', err);
        this.mensaje = 'Error al crear abogado';
        this.loading = false;
      }
    });
  }
}
