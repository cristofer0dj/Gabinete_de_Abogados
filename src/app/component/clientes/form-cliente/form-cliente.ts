import { Component, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-form-cliente',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './form-cliente.html',
  styleUrls: ['./form-cliente.css'],
})
export class FormCliente {
  @Output() accionRealizada = new EventEmitter<any>();

  // Variables del formulario
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

    // Validaciones básicas
    if (!this.nombre || !this.apellido || !this.telefono || !this.email) {
      this.mensaje = 'Todos los campos son obligatorios';
      this.loading = false;
      return;
    }

    const datosCliente = {
      nombre: this.nombre,
      apellido: this.apellido,
      telefono: this.telefono,
      email: this.email,
    };

    console.log('Enviando datos:', datosCliente);
    
    this.apiService.crearCliente(datosCliente).subscribe({
      next: (result) => {
        console.log('Cliente creado exitosamente:', result);
        this.mensaje = 'Cliente creado exitosamente!';
        this.loading = false;

        // Limpiar formulario
        this.nombre = '';
        this.apellido = '';
        this.telefono = '';
        this.email = '';

        // Emitir evento para recargar lista tras 1.5s
        setTimeout(() => {
          this.accionRealizada.emit(1);
        }, 1500);
      },
      error: (err) => {
        console.error('Error completo:', err);
        console.error('Status:', err.status);
        console.error('Mensaje:', err.message);
        this.mensaje = `Error: ${err.status} - ${err.statusText || err.message}`;
        this.loading = false;
      }
    });
  }
}
