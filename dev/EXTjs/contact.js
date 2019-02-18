Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', '../ux');

Ext.require([
    'Ext.data.*',
    'Ext.grid.*',
    'Ext.util.*',
    'Ext.form.*',
    'Ext.layout.container.Column',
    'Ext.tab.Panel'
]);

Ext.onReady(function(){

    // define grid
    var contact_grid_df = Ext.define('Contact_List',{
        extend: 'Ext.data.Model',
        fields:
            [
                'id',
                'fname',
                'lname',
                'email',
                'phone',
                'dob'
            ],
    });

    // create the Data Store
    var contact_list_store = Ext.create('Ext.data.JsonStore', { 
        storeId: 'myData',
        reader: new Ext.data.JsonReader({
            fields:
                [{
                    name: "id",
                    type: "int"
                },{
                    name: "fname",
                    type: "string"
                },{
                    name: "lname",
                    type: "string"
                },{
                    name: "email",
                    type: "string"
                },{
                    name: "phone",
                    type: "string"
                },{ 
                    name: 'dob', 
                    type: 'date', 
                    dateFormat: 'Y-m-d'
                }]
        }),  
        proxy: new Ext.data.HttpProxy({
            url: '../process_contactform.php/GetContactFormList/',
            headers: {
                'content-type': 'application/json'
            }
        }),
        model: contact_grid_df,
        autoLoad: true
    });

    // create the form
    var contact_form = Ext.create('Ext.form.Panel', {
        title: 'Contact Form',
        width: 350,
        height: 250,
        layout: 'fit',
        items: {
            id: 'contact-form',
            xtype: 'form',
            width: 740,
            height: 200,
            bodyPadding: 15,
            url: '../process_contactform.php/SubmitForm/',
            waitMsgTarget:'',
            waitTitle:'Connecting',
            waitMsg: 'Sending data...',
            items: 
                [{
                    fieldLabel: 'First Name',
                    name: 'fname',
                    id: 'Fname',
                    allowBlank:false,
                    xtype: 'textfield',
                    tooltip: 'Enter your email address'
                },{
                    fieldLabel: 'Last Name',
                    name: 'lname',
                    id:'Lname',
                    allowBlank:false,
                    xtype: 'textfield',
                    tooltip: 'Enter your email address'
                },{
                    fieldLabel: 'Email',
                    name: 'email',
                    id:'email',
                    allowBlank:false,
                    xtype: 'textfield',
                    tooltip: 'Enter your email address'
                },{
                    fieldLabel: 'Telephone',
                    name: 'phone',
                    id:'phone',
                    allowBlank:false,
                    xtype: 'textfield',
                    tooltip: 'Enter your Telephone Number'
                },{
                    fieldLabel: 'Date Of Birth',
                    name: 'dob',
                    id:'dob',
                    allowBlank:false,
                    xtype: 'datefield',
                    format: 'Y-m-d', 
                    tooltip: 'Enter your Date Of Birth'
                }],
            buttons: [{
                text: 'Save',
                handler: function(){
                    var form = this.up('form').getForm();
                    // var store = Ext.getStore(contact_list_store);
                    // var xid = JSON.parse(store.last().internalId) + 1;
                    // var xindex = JSON.parse(store.last().index) + 1;
                    // var data = form.getValues();
                    // data.id = xid+"";
                    // Contact_List = new Contact_List(data,[xindex]);
                    // Contact_List[index] =  xindex;
                    // store.data.map[xid] = Contact_List;
                    if (form.isValid()) {
                        form.submit({
                            success: function(form, action) {
                            Ext.Msg.alert('Success', action.result.message);
                            },
                            failure: function(form, action) {
                                Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
                            }
                        });
                    } else {
                        Ext.Msg.alert( "Error!", "Your form is invalid!" );
                    }
                }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                }
            }]
        }
    });

    // create the grid panel
    var contact_list =  Ext.create('Ext.grid.Panel', {
        title: 'Contact List',
        clicksToEdit: 1,
        store: contact_list_store,
        columns: 
                [{
                    header: "S/N",
                    width:150,
                    dataIndex: 'id'
                },{
                    header: "Frist Name",
                    width:150,
                    dataIndex: 'fname'
                },{
                    header: "Last Name",
                    width:150,
                    dataIndex: 'lname'
                },{
                    header: "Email",
                    width:150,
                    dataIndex: 'email'
                },{
                    header: "Telephone",
                    width:150,
                    dataIndex: 'phone'
                },{
                    header: "Date Of Birth",
                    width:150,
                    dataIndex: 'dob', 
                    format: 'm-d-Y', 
                    xtype: 'datecolumn'
                },{
                    xtype: 'actioncolumn',
                    width: 30,
                    sortable: false,
                    menuDisabled: true,
                    items: [{
                        icon: '../app/resources/images/icons/delete.gif',
                        tooltip: 'Remove',
                        handler: function(grid, rowIndex){
                            var id = grid.getStore().getAt(rowIndex).data.id;
                            Ext.Ajax.request({
                                url: '../process_contactform.php/RemoveItem/',
                                method: 'POST',
                                waitTitle: 'Connecting',
                                waitMsg: 'Sending data...',                                     
                                params: {
                                    "id" : id
                                },
                                scope:this,
                                success: function(action) {
                                    contact_list_store.removeAt(rowIndex);
                                    Ext.Msg.alert('Success', JSON.parse(action.responseText).message);
                                },
                                failure: function(action) {
                                    Ext.Msg.alert('Failed', action.responseText ? JSON.parse(action.responseText).message: 'No response');
                                }
                            });
                        }
                    }]
                }],
        width: '100%',
        height: 280
    });

    contact_form.render(document.getElementById('contact_form'));
    contact_list.render(document.getElementById('contact_list'));
});





