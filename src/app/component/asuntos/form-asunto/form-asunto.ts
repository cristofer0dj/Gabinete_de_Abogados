import { Component, Output, EventEmitter, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-form-asunto',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './form-asunto.html',
  styleUrls: ['./form-asunto.css']
})
export class FormAsunto implements OnInit {
  @Output() accionRealizada = new EventEmitter<any>();

  // Variables del formulario
  expediente: string = '';
  descripcion: string = '';
  estado: string = 'En proceso';
  fechainicio: string = '';
  fechafin: string = '';
  idcliente: number = 0;

  // Listas para selects
  clientes: any[] = [];
  mensaje: string = '';
  loading: boolean = false;

  constructor(private apiService: ApiServiceTs) {}

  ngOnInit(): void {
    this.cargarClientes();
    // Establecer fecha actual como fecha inicio
    this.fechainicio = new Date().toISOString().split('T')[0];
  }

  cargarClientes() {
    this.apiService.getClientes().subscribe({
      next: (result) => {
        console.log('Clientes cargados:', result);
        this.clientes = result;
      },
      error: (err) => {
        console.log('Error al cargar clientes:', err);
      }
    });
  }

  guardar() {
    this.loading = true;
    this.mensaje = '';

    // Validaciones
    if (!this.expediente || !this.descripcion || !this.idcliente) {
      this.mensaje = 'Expediente, descripción y cliente son obligatorios';
      this.loading = false;
      return;
    }

    const datosAsunto = {
      expediente: this.expediente,
      descripcion: this.descripcion,
      estado: this.estado,
      fechainicio: this.fechainicio,
      fechafin: this.fechafin || null,
      idcliente: this.idcliente
    };

    console.log('Enviando asunto:', datosAsunto);

    this.apiService.crearAsunto(datosAsunto).subscribe({
      next: (result) => {
        console.log('Asunto creado:', result);
        this.mensaje = 'Asunto creado exitosamente!';
        this.loading = false;

        // Limpiar formulario
        this.expediente = '';
        this.descripcion = '';
        this.estado = 'En proceso';
        this.fechainicio = new Date().toISOString().split('T')[0];
        this.fechafin = '';
        this.idcliente = 0;

        // Recargar lista después de 1.5 segundos
        setTimeout(() => {
          this.accionRealizada.emit(1);
        }, 1500);
      },
      error: (err) => {
        console.log('Error al crear asunto:', err);
        this.mensaje = 'Error al crear el asunto';
        this.loading = false;
      }
    });
  }
}
