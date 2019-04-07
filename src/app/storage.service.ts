import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';  // Import it up here

@Injectable({
  	providedIn: 'root'
})

export class StorageService {
 	constructor(private http: HttpClient) { }
	set(alerts: string) {
		localStorage.setItem('alerts', JSON.stringify(alerts));
	}
	get() {
		return JSON.parse(localStorage.getItem('alerts'));
	}
}