import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { catchError, tap, map } from 'rxjs/operators';
import { Ob } from './ob';
import { Obdim } from './obdim';
import { AuthService } from './auth/auth.service';

const httpOptions = {
  headers: new HttpHeaders({'Content-Type': 'application/json'})
};
const apiUrl = 'https://alerts.quercus.com.gr/api';

@Injectable()
export class ObService {
	
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

  getObs() {
    return this.http
      .get<Ob[]>(`${apiUrl}/observations/${this.authService.userID}`, {
        headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)
      })
      .pipe(
        catchError(this.handleError)
      );
  }

	addOb (ob): Observable<Ob> {
		const url = `${apiUrl}/observations`;
		return this.http.post<Ob>(url, ob, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)}).pipe(
			tap((ob: Ob) => console.log(`added observation w/ id=${ob.observation_id}`)),		
			catchError(this.handleError<Ob>('addOb'))
		);
	}

	addObdim (obdim): Observable<Obdim> {
		const url = `${apiUrl}/observations_dim`;
		return this.http.post<Obdim>(url, obdim, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)}).pipe(
			catchError(this.handleError<Obdim>('addObdim'))
		);
	}

}
