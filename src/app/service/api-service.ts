import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiServiceTs {

  private apiUrl = 'http://localhost/backend/public/despacho/';

  private httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
    })
  };

  constructor(private http: HttpClient) { }

  // Clientes
  getClientes(): Observable<any> {
    return this.http.get(this.apiUrl + 'lista', this.httpOptions);
  }

  crearCliente(cliente: any): Observable<any> {
    return this.http.post(this.apiUrl + 'nuevo_cliente', cliente, this.httpOptions);
  }

  eliminarCliente(id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}eliminar_cliente`, { id: id }, this.httpOptions);
  }

  // Abogados
  getAbogados(): Observable<any> {
    return this.http.get(this.apiUrl + 'abogados', this.httpOptions);
  }

  crearAbogado(abogado: any): Observable<any> {
    return this.http.post(this.apiUrl + 'nuevo_abogado', abogado, this.httpOptions);
  }

  eliminarAbogado(id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}eliminar_abogado`, { id: id }, this.httpOptions);
  }

  // Asuntos
  getAsuntos(): Observable<any> {
    return this.http.get(this.apiUrl + 'asuntos', this.httpOptions);
  }

  crearAsunto(asunto: any): Observable<any> {
    return this.http.post(this.apiUrl + 'nuevo_asunto', asunto, this.httpOptions);
  }

  eliminarAsunto(id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}eliminar_asunto`, { id: id }, this.httpOptions);
  }

  // Asignaciones
  vincularAbogadoAsunto(vinculo: any): Observable<any> {
    return this.http.post(this.apiUrl + 'casos_abogado', vinculo, this.httpOptions);
  }

  eliminarAsignacion(idasunto: number, idabogado: number): Observable<any> {
    return this.http.post(`${this.apiUrl}eliminar_asignacion`, { idasunto, idabogado }, this.httpOptions);
  }
}

