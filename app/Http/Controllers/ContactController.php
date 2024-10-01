<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;
use App\Models\Contact;
class ContactController extends Controller
{
    // Import file view
    public function index(){
        return view('contact_import');
    }

    // Get contact list
    public function getcontactList(){
        $list = Contact::orderBy('id', 'desc')->paginate(10);
        return view('contact_list', ['list' => $list]);
    }
    //update or insert contact
    public function saveContact(Request $request){
        $contactName = $request->contactName;
        $contactLastname = $request->contactLastname;
        $contactPhone = $request->contactPhone;
        $contactId = $request->contactId;
        if($contactId!=''){
            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->name = $contactName;
                $contact->last_name = $contactLastname;
                $contact->phone =  $contactPhone;
                $contact->save();
                session()->flash('success', 'Contact updated successfully!');
            }else{
                session()->flash('error', 'Contact not found!');
            }
        }else{
            $contact = new Contact;
            $contact->name = $contactName;
            $contact->last_name = $contactLastname;
            $contact->phone =  $contactPhone;
            $contact->save();
            session()->flash('success', 'Contact saved successfully!');
        }
        return redirect()->back();
    }
    
    // Delete Contact
    public function deleteContact(Request $request){
        $res = Contact::find($request->id);
        $res->delete();
        $arr = array();
        if($res){
            $arr = array(
                'status'=>1,
                'msg'=>'Contact deleted successfully',
            );
        }else{
            $arr = array(
                'status'=>0,
                'msg'=>'Something went wrong',
            );
        }
        return response()->json($arr);
    }

    // import xml file
    public function importXML(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:2048',
        ]);

        // Get the uploaded XML file
        $file = $request->file('xml_file');
        $xmlContent = file_get_contents($file->getRealPath());

        // Parse XML using SimpleXML
        $xml = new SimpleXMLElement($xmlContent);

        // Process the XML data and save it to the database
        foreach ($xml->contact as $item) {
            
            $name = (string) $item->name;
            $lastName = (string) $item->lastName;
            $phone = (string) $item->phone;
           
           Contact::create([
                'name' => $name,
                'last_name' => $lastName,
                'phone' => $phone,
            ]);
        }

        // Return a success message
        return redirect()->back()->with('message', 'XML File Imported Successfully!');
    }
}

?>