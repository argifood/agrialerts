import { Injectable } from '@angular/core';
import { Alert } from '../shared/alert';  // alert data type interface class
import { AngularFireDatabase, AngularFireList, AngularFireObject } from '@angular/fire/database';  // Firebase modules for Database, Data list and Single object

@Injectable({
  providedIn: 'root'
})

export class CrudService {
  alertsRef: AngularFireList<any>;    // Reference to alert data list, its an Observable
  alertRef: AngularFireObject<any>;   // Reference to alert object, its an Observable too
  
  // Inject AngularFireDatabase Dependency in Constructor
  constructor(private db: AngularFireDatabase) { }

  // Fetch alerts List
  GetalertsList() {
    this.alertsRef = this.db.list('alerts-list');
    return this.alertsRef;
  }    
}