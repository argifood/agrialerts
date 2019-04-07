import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { catchError, tap, map } from 'rxjs/operators';
import { Pref } from './pref';
import { AuthService } from './auth/auth.service';

const httpOptions = {
  headers: new HttpHeaders({'Content-Type': 'application/json'})
};
const apiUrl = 'https://alerts.quercus.com.gr/api/user';

@Injectable()
export class PrefsService {

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

	getPrefs (): Observable<Pref[]> {
		const url = `${apiUrl}/${this.authService.userID}/prefs`;
		return this.http.get<Pref[]>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)})
		.pipe(
			tap(heroes => console.log(`fetched prefs from url: ${apiUrl}/${this.authService.userID}/prefs`)),
			catchError(this.handleError('getPrefs', []))
		);
	}

	getPref(id: number): Observable<Pref> {
		const url = `${apiUrl}/${this.authService.userID}/prefs/${id}`;
		return this.http.get<Pref>(url, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)}).pipe(
			tap(_ => console.log(`fetched pref id=${id}`)),
			catchError(this.handleError<Pref>(`getPref id=${id}`))
		);
	}

	addPref (pref): Observable<Pref> {
		const url = `${apiUrl}/prefs`;
		return this.http.post<Pref>(url, pref, {headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)}).pipe(
			catchError(this.handleError<Pref>('addPref'))
		);
	}

	updatePref (id: number, pref): Observable<any> {
		const url = `${apiUrl}/${this.authService.userID}/prefs/${id}`;
		return this.http.put(url, pref, httpOptions).pipe(
			tap(_ => console.log(`updated pref id=${id}`)),
			catchError(this.handleError<any>('updatePref'))
		);
	}

	deletePref (id: number): Observable<Pref> {
		const url = `${apiUrl}/${this.authService.userID}/prefs/${id}`;
		return this.http.delete<Pref>(url, httpOptions).pipe(
			tap(_ => console.log(`deleted pref id=${id}`)),
			catchError(this.handleError<Pref>('deletePref'))
		);
	}
}
