import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { forkJoin } from 'rxjs';
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
    // Cargar asuntos y clientes en paralelo para mapear nombre de cliente
    forkJoin({
      asuntos: this.ApiService.getAsuntos(),
      clientes: this.ApiService.getClientes()
    }).subscribe({
      next: ({ asuntos, clientes }) => {
        console.log('Asuntos recibidos:', asuntos);
        console.log('Clientes recibidos:', clientes);

        const clienteMap: Record<string, string> = {};
        if (Array.isArray(clientes)) {
          clientes.forEach((c: any) => {
            // buscar distintos posibles campos de id y nombre
            const id = c.id ?? c.idcliente ?? c.ID ?? c.Id ?? c.id_cliente ?? c.cliente_id;
            const nombre = c.nombre ?? c.nombre_cliente ?? c.name ?? `${c.nombre || ''} ${c.apellido || ''}`.trim();
            if (id != null) clienteMap[String(id)] = nombre || '-';
          });
        }

        if (Array.isArray(asuntos)) {
          this.data = asuntos.map((a: any) => {
            const idCliente = a.idcliente ?? a.id_cliente ?? a.cliente_id ?? a.cliente ?? a.client;
            return {
              ...a,
              nombre_cliente: clienteMap[String(idCliente)] || '-'
            };
          });
        } else {
          this.data = [];
        }
      },
      error: (err) => {
        console.error('Error al cargar asuntos o clientes:', err);
        this.data = [];

      }
    });
  }


}




