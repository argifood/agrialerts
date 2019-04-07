import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { throwError, Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Alert } from './alert';
import { AuthService } from './auth/auth.service';

@Injectable()
export class AlertService {
  // Define the routes we are going to interact with
  private privateAlertsUrl = 'https://alerts.quercus.com.gr/api/alerts/';

  constructor(
	private http: HttpClient,
	private authService: AuthService
  ) { }

  // Implement a method to get the private deals
  getPrivate() {
    return this.http
      .get<Alert[]>(this.privateAlertsUrl + this.authService.userID, {
        headers: new HttpHeaders().set('Authorization', `Bearer ${this.authService.accessToken}`)
      })
      .pipe(
        catchError(this.handleError)
      );
  }

  // Implement a method to handle errors if any
  private handleError(err: HttpErrorResponse | any) {
    console.error('An error occurred', err);
    return throwError(err.message || err);
  }

}