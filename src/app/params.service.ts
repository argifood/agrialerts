import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { catchError, tap, map } from 'rxjs/operators';
import { Agritype } from './agritype';
import { Alerttype } from './alerttype';
import { Nuts2 } from './nuts2';
import { Nuts3 } from './nuts3';
import { Nuts5 } from './nuts5';
import { AuthService } from './auth/auth.service';

const apiUrl = 'https://alerts.quercus.com.gr/api';

@Injectable()
export class ParamsService {

  constructor(
		private http: HttpClient,
		private authService: AuthService
	) { }

  private handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {

			// TODO: send the error to remote logging infrastructure
			console.error(error); // log to console instead

			// Let the app keep running by returning an empty result.
			return of(result as T);
		};
	}	

	getAgritypes (): Observable<Agritype[]> {
		const url = `${apiUrl}/agritypes`;
		return this.http.get<Agritype[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			catchError(this.handleError('getAgritypes', []))
		);
	}
	
	getAlerttypes (): Observable<Alerttype[]> {
		const url = `${apiUrl}/alerttypes`;
		return this.http.get<Alerttype[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			catchError(this.handleError('getAlerttypes', []))
		);
	}
	
	getNuts2 (): Observable<Nuts2[]> {
		const url = `${apiUrl}/nuts2`;
		return this.http.get<Nuts2[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			catchError(this.handleError('getNuts2', []))
		);
	}
	
	getNuts3 (id: number): Observable<Nuts3[]> {
		const url = `${apiUrl}/nuts3/${id}`;
		return this.http.get<Nuts3[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			catchError(this.handleError('getNuts3', []))
		);
	}
	
	getNuts5 (id: string): Observable<Nuts5[]> {
		const url = `${apiUrl}/nuts5/${id}`;
		return this.http.get<Nuts5[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			catchError(this.handleError('getNuts5', []))
		);
	}
}
