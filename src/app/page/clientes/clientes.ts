import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Menu } from '../../component/menu/menu';
import { ListaClientes } from '../../component/clientes/lista-clientes/lista-clientes';
import { FormCliente } from '../../component/clientes/form-cliente/form-cliente';

@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [CommonModule, Menu, ListaClientes, FormCliente],
  templateUrl: './clientes.html',
  styleUrls: ['./clientes.css'],
})
export class Clientes {
  lista: boolean = true;

  mostrar() {
    this.lista = !this.lista;
  }

  recargar() {
    this.mostrar();
  }
}
