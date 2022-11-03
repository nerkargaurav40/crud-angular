import { Injectable } from '@angular/core';
import { HttpClient, HttpParams} from '@angular/common/http';
import { Students } from './students';
@Injectable({
  providedIn: 'root'
})
export class StudentsService {

  constructor( private http: HttpClient) { }
  base_url: String = 'http://localhost/phprestAPI/index.php';

  getStudents()
  {
    return this.http.get<Students[]>(this.base_url+'?xAction=getAll');
  }

  getSingleStudent(id:any)
  {
    return this.http.get<Students[]>(this.base_url+'?xAction=getAll&id='+id);
  }

  deleteStudent(id: any)
  {
    return this.http.delete(this.base_url+'?xAction=deleteRecord&id='+id);
  }

  createStudent(data:any)
  {
    return this.http.post(this.base_url+'?xAction=insertRecord',data);
  }
  
  editStudent(data:any)
  {
    return this.http.put(this.base_url+'?xAction=updateRecord',data);
  }
}
