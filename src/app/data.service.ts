import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';  // Import it up here

@Injectable({
  providedIn: 'root'
})

export class DataService {
	result: string;
  	constructor(private http: HttpClient) { }
  	getPreferences() {
  		localStorage.removeItem("preferences");
	    return this.http.get('http://46.101.117.105/preferences')
	}
}