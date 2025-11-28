import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiServiceTs } from '../../../service/api-service.ts.js';

@Component({
  selector: 'app-lista-clientes',
  imports: [CommonModule],
  templateUrl: './lista-clientes.html',
  styleUrl: './lista-clientes.css',
})
// component/clientes/lista-clientes/lista-clientes.component.ts
export class ListaClientes implements OnInit {
  data: any = [];

  constructor(private apiService: ApiServiceTs) {}

  ngOnInit(): void {
    this.cargar();
  }

  cargar() {
    this.apiService.getClientes().subscribe({
      next: (result) => {
        console.log(result);
        this.data = result;
      },
      error: (err) => {
        console.log(err);
      }
    });
  }

  // FUNCIÓN ELIMINAR - Según tu patrón
  eliminar(id: number) {
    if (confirm('¿Estás seguro de eliminar este cliente?')) {
      this.apiService.eliminarCliente(id).subscribe({
        next: (result) => {
          console.log(result);
          this.cargar(); // Recargar la lista después de eliminar
        },
        error: (err) => {
          console.log(err);
        }
      });
    }
  }
}