import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';  // Import it up here

@Injectable({
  	providedIn: 'root'
})

export class GetalertsService {
  	constructor(private http: HttpClient) { }
  	getAlerts() {
	    return this.http.get('./assets/alerts.json')
	}
}