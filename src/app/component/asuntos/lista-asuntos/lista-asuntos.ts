import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-lista-asuntos',
  imports: [CommonModule],
  templateUrl: './lista-asuntos.html',
  styleUrls: ['./lista-asuntos.css'],
})

export class ListaAsuntos implements OnInit {
  data: any[] = [];
  
  constructor(private ApiService: ApiServiceTs) { }
  ngOnInit(): void {
    this.cargar();
  }
  cargar() {
    this.ApiService.getAsuntos().subscribe({
      next: (result) => {
        console.log('Datos recibidos completos:', result);
        if (result && result.length > 0) {
          console.log('Estructura del primer asunto:', result[0]);
          console.log('Propiedades disponibles:', Object.keys(result[0]));
        }
        this.data = result;
      },
      error: (err) => {
        console.error('Error al cargar asuntos:', err);
        this.data = [];
      }
    });
  }
}



