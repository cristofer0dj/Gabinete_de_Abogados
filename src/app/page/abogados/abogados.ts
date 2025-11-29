import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Menu } from '../../component/menu/menu';
import { ListaAbogados } from '../../component/abogados/lista-abogados/lista-abogados';
import { FormAbogado } from '../../component/abogados/form-abogado/form-abogado';

@Component({
  selector: 'app-abogados',
  standalone: true,
  imports: [CommonModule, Menu, ListaAbogados, FormAbogado],
  templateUrl: './abogados.html',
  styleUrls: ['./abogados.css']
})

export class Abogados {
  lista: boolean = true;

  mostrar() {
    this.lista = !this.lista;
  }

  recargar() {
    this.mostrar();
  }
}