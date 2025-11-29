import { Component, OnInit } from '@angular/core';
import { ApiServiceTs } from '../../../service/api-service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-lista-abogados',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './lista-abogados.html',
  styleUrls: ['./lista-abogados.css']
})
export class ListaAbogados implements OnInit {
  data: any = [];
  loading: boolean = true;
  error: string = '';

  constructor(private apiService: ApiServiceTs) {}

  ngOnInit(): void {
    this.cargar();
  }

  cargar() {
    this.loading = true;
    this.error = '';
    
    this.apiService.getAbogados().subscribe({
      next: (result) => {
        console.log('Abogados:', result);
        this.data = result;
        this.loading = false;
      },
      error: (err) => {
        console.log('Error:', err);
        this.error = 'Error al cargar abogados';
        this.loading = false;
        this.data = [];
      }
    });
  }
}