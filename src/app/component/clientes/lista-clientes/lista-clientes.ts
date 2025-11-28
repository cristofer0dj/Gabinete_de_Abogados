import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiServiceTs } from '../../../service/api-service';

@Component({
  selector: 'app-lista-clientes',
  imports: [CommonModule],
  templateUrl: './lista-clientes.html',
  styleUrls: ['./lista-clientes.css'],
})

export class ListaClientes implements OnInit {
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
        console.error('Error al cargar clientes:', err);
        this.data = [];
      }
    });
  }
}

