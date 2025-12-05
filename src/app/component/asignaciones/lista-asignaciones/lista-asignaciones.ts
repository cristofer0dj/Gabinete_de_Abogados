import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-lista-asignaciones',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './lista-asignaciones.html',
  styleUrls: ['./lista-asignaciones.css']
})
export class ListaAsignaciones implements OnInit {
  asuntos: any[] = [];
  loading: boolean = true;
  error: string = '';

  constructor(private apiService: ApiServiceTs) {}

  ngOnInit(): void {
    this.cargar();
  }

  cargar() {
    this.loading = true;
    this.error = '';
    
    this.apiService.getAsuntos().subscribe({
      next: (result) => {
        console.log('Asuntos con asignaciones:', result);
        this.asuntos = result;
        this.loading = false;
      },
      error: (err) => {
        console.log('Error:', err);
        this.error = 'Error al cargar asignaciones';
        this.loading = false;
        this.asuntos = [];
      }
    });
  }

  recargar() {
    this.cargar();
  }
}

