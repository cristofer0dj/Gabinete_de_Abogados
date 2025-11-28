import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiServiceTs } from '../../../service/api-service.ts.js';

@Component({
  selector: 'app-lista-asuntos',
  imports: [CommonModule],
  templateUrl: './lista-asuntos.html',
  styleUrl: './lista-asuntos.css',
})

export class ListaAsuntos implements OnInit {
  data: any[] = [];
  
  constructor(private ApiService: ApiServiceTs) { }
  ngOnInit(): void {
    this.cargar();
  }
  cargar() {
    this.ApiService.getClientes().subscribe({
      next: (result) => {
        console.log('Datos recibidos:', result);
        this.data = result;
      },
      error: (err) => {
        console.error('Error al cargar asuntos:', err);
        this.data = [];
      }
    });
  }
}



