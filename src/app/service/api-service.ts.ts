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
    return this.http.get(this.apiUrl + 'lista', this.httpOptions).pipe(res=>res);
  }

  crearCliente(cliente: any): Observable<any> {
    return this.http.post(this.apiUrl + 'nuevo_cliente', cliente, this.httpOptions).pipe(res=>res);
  }

  // Abogados
  getAbogados(): Observable<any> {
    return this.http.get(this.apiUrl + 'abogados', this.httpOptions).pipe(res=>res);
  }

  // Asuntos
  getAsuntos(): Observable<any> {
    return this.http.get(this.apiUrl + 'asuntos', this.httpOptions).pipe(res=>res);
  }

  crearAsunto(asunto: any): Observable<any> {
    return this.http.post(this.apiUrl + 'nuevo_asunto', asunto, this.httpOptions).pipe(res=>res);
  }

  vincularAbogadoAsunto(vinculo: any): Observable<any> {
    return this.http.post(this.apiUrl + 'casos_abogado', vinculo, this.httpOptions).pipe(res=>res);
  }
}
