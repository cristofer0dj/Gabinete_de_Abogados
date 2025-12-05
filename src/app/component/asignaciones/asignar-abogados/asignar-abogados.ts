// component/asignaciones/asignar-abogados/asignar-abogados.component.ts
import { Component, Output, EventEmitter, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-asignar-abogados',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './asignar-abogados.html',
  styleUrls: ['./asignar-abogados.css']
})
export class AsignarAbogadosComponent implements OnInit {
  @Output() accionRealizada = new EventEmitter<any>();

  asuntos: any[] = [];
  abogados: any[] = [];
  asuntoSeleccionado: number = 0;
  abogadoSeleccionado: number = 0;
  rol: string = 'Abogado Principal';
  fechaAsignacion: string = '';
  mensaje: string = '';
  loading: boolean = false;

  roles: string[] = [
    'Abogado Principal',
    'Abogado Secundario', 
    'Notario',
    'Mediador',
    'Consultor Legal',
    'Asesor'
  ];

  constructor(private apiService: ApiServiceTs) {}

  ngOnInit(): void {
    this.cargarDatos();
    this.fechaAsignacion = new Date().toISOString().split('T')[0];
  }

  cargarDatos() {
    // Cargar asuntos
    this.apiService.getAsuntos().subscribe({
      next: (result) => {
        this.asuntos = result;
      },
      error: (err) => {
        console.log('Error al cargar asuntos:', err);
        this.mensaje = 'Error al cargar la lista de casos';
      }
    });

    // Cargar abogados
    this.apiService.getAbogados().subscribe({
      next: (result) => {
        this.abogados = result;
      },
      error: (err) => {
        console.log('Error al cargar abogados:', err);
        this.mensaje = 'Error al cargar la lista de abogados';
      }
    });
  }

  asignarAbogado() {
    if (!this.asuntoSeleccionado || !this.abogadoSeleccionado || !this.rol) {
      this.mensaje = 'Todos los campos son obligatorios';
      return;
    }

    this.loading = true;
    this.mensaje = '';

    const datosVinculo = {
      idasunto: this.asuntoSeleccionado,
      idabogado: this.abogadoSeleccionado,
      rol: this.rol,
      fechassignacion: this.fechaAsignacion
    };

    console.log('Asignando abogado:', datosVinculo);

    this.apiService.vincularAbogadoAsunto(datosVinculo).subscribe({
      next: (result) => {
        console.log('Respuesta del servidor:', result);
        this.loading = false;
        
        if (result && (result.success || result.status === 201)) {
          this.mensaje = '✓ ¡Abogado asignado exitosamente al caso!';
          
          // Limpiar formulario después de 2 segundos
          setTimeout(() => {
            this.asuntoSeleccionado = 0;
            this.abogadoSeleccionado = 0;
            this.rol = 'Abogado Principal';
            this.fechaAsignacion = new Date().toISOString().split('T')[0];
            this.mensaje = '';
            this.accionRealizada.emit(1);
          }, 2000);
        } else {
          this.mensaje = result?.message || 'Asignación completada';
          setTimeout(() => this.accionRealizada.emit(1), 1000);
        }
      },
      error: (err) => {
        console.error('Error completo:', err);
        console.log('Error al asignar abogado:', err);
        this.loading = false;
        
        // Intentar parsear el error
        if (err.error) {
          try {
            const errorResponse = typeof err.error === 'string' ? JSON.parse(err.error) : err.error;
            this.mensaje = `Error: ${errorResponse.error || errorResponse.message || 'Error desconocido'}`;
          } catch (e) {
            this.mensaje = `Error al asignar el abogado: ${err.statusText || 'Error de conexión'}`;
          }
        } else {
          this.mensaje = 'Error al asignar el abogado al caso';
        }
      }
    });
  }
}
