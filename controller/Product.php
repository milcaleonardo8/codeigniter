<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN.'Adminmodel');
	}

	/*Load data*/
	public function index()
	{
		$this->general->adminauth();
		$data['products'] = $this->Adminmodel->getproduct();
		$data['categories'] = $this->Adminmodel->get_all_selected('tblcategory','CateId,Name,Slug');
		$this->load->view(ADMIN.'product_view_new',$data);
	}

	/*For Add/edit product*/
	public function add($id = '',$cate = '')
	{	
		$data['categories'] = $this->common->get_all_record('tblcategory');
		if($id != ''){
			$data['opr'] = 'Edit';
		}
		else{
			if($cate != ''){
				$data['edit']['CId'] = $cate;
			}
			$data['opr'] = 'Add';
		}
		$data['edit'] = $this->common->get_one_row('tblcard',array('md5(CardId)'=>$id));
		if(empty($data['edit']) && $id != ''){
			redirect(base_url(ADMIN.'Product'));
		}
		$this->load->view(ADMIN.'add_product',$data);
	}

	/*For View product by category*/
	public function view_category($cateid = '')
	{
		if($cateid != ''){
			$desc = $this->common->get_one_row('tblcategory',array('md5(CateId)'=>$cateid)); 
			$data['CateId'] = $desc['CateId'];
			$data['CateName'] = $desc['Name'];
			$data['products'] = $this->Adminmodel->getproduct(array('md5(td.CId)'=>$cateid));
			$this->load->view(ADMIN.'view_product_by_category',$data);
		} else {
			redirect(base_url(ADMIN.'Product'));
		}
		
	}

	/*For View product by sub category*/
	public function view_category_sub($cateid = '')
	{
		if($cateid != ''){
			$desc = $this->common->get_one_row('tblsubcategory',array('md5(CateId)'=>$cateid)); 
			$data['SubCateId'] = $desc['CateId'];
			$data['CateName'] = $desc['Name'];
			$data['products'] = $this->Adminmodel->getsubproduct(array('md5(td.SubCateId)'=>$cateid));
			//echo "<pre>"; print_r($data); exit;
			$this->load->view(ADMIN.'view_product_by_category',$data);
		} else {
			redirect(base_url(ADMIN.'Product'));
		}
	}
	/*For Submit data for Add product process*/
	public function saveprocess()
	{
		$CId 			= $this->input->post('CId');
		$SubCateId 		= $this->input->post('SubCateId');
		$CardName 		= $this->input->post('CardName');
		$Link 			= $this->input->post('Link');
		$Title 			= $this->input->post('Title');
		$Description	= $this->input->post('Description');
		$Overview 		= $this->input->post('Overview');
		$PricingText 	= $this->input->post('PricingText');
		$SizingText 	= $this->input->post('SizingText');
		$ImageAlt 		= $this->input->post("ImageAlt");

		$this->form_validation->set_rules('CardName', 'Card Name', 'required');
		$this->form_validation->set_rules('Description','Description','required');
		$this->form_validation->set_rules('Overview','Overview','required');
		$this->form_validation->set_rules('PricingText','PricingText','required');
		$this->form_validation->set_rules('SizingText','SizingText','required');
		if ($this->form_validation->run() == TRUE){

			/*Check duplicate*/
			$already = $this->common->prepare_array_from_table('tblcard','CardName');
			if(in_array($CardName,$already)){
				$this->session->set_flashdata('error',' Name Is Exist Choose Different Name!!');
				redirect(base_url(ADMIN.'Product'));
			}
			/*Check duplicate End*/

			$CardSlug = $this->general->createslug($CardName);
			$data 	= array(
					'Title'			=>	$Title,
					'CardName'		=>	$CardName,
					'CardSlug'		=>	$CardSlug,
					'Description'	=>	$Description,
					'Overview'		=>	$Overview,
					'PricingText'	=>	$PricingText,
					'SizingText'	=>	$SizingText,
					'Link'			=>	$Link,
					'CId'			=>	$CId,
					'SubCateId'		=>	$SubCateId,
					"ImageAlt"		=>	$ImageAlt
				);

			/*Image uploading*/
			if ($_FILES['Image']['error'] == 0) {
	            $ext 		= $this->general->checkext('Image',ADMIN.'Product');
	            $result 	= $this->general->upload_file("Image",PRODUCTPATH, time().'_'.rand().'.'.$ext, "jpg|png|jpeg");
	            if (is_array($result)) {
	                $this ->session->set_flashdata("error", "Image Not Uploaded.!!!");
	                redirect(base_url(ADMIN.'Product'));
	            }
	            //170*242
	            $this->load->library('imageupload');
	            $res = $this->imageupload->resize_image(PRODUCTPATH,$result, PRODUCTPATH.'Thumb/', '170', '242');
	            $data['Image'] = $result;
	        }
	        /*Image uploading End*/

			$res 	= $this->common->insert_record('tblcard',$data);
			$this->general->processandredirect($res,'Product Added Successfully','Product Not Added',ADMIN.'Product');
		} else {
			$this->session->set_flashdata('error','Please Fill The Data First!!'.validation_errors());
			redirect(base_url(ADMIN.'Product/add'));
			$this->add();
		}
	}
	/*For Submit data for Edit product process*/
	public function editprocess()
	{
		$CardId 		= $this->input->post('CardId');
		$SubCateId 		= $this->input->post('SubCateId');
		$CId 			= $this->input->post('CId');
		$Title 			= $this->input->post('Title');
		$CardName 		= $this->input->post('CardName');
		$Link 			= $this->input->post('Link');
		$Description 	= $this->input->post('Description');
		$Overview 		= $this->input->post('Overview');
		$PricingText 	= $this->input->post('PricingText');
		$SizingText 	= $this->input->post('SizingText');
		$OldImage 		= $this->input->post('OldImage');//Old Image
		$ImageAlt 		= $this->input->post("ImageAlt");
		
		$this->form_validation->set_rules('CardName', 'Card Name', 'required');
		$this->form_validation->set_rules('Description','Description','required');
		$this->form_validation->set_rules('Overview','Overview','required');
		$this->form_validation->set_rules('PricingText','PricingText','required');
		$this->form_validation->set_rules('SizingText','SizingText','required');
		if ($this->form_validation->run() == TRUE){
			/*Check duplicate*/
			$already = $this->common->prepare_array_from_table('tblcard','CardName',array('CardId !='=>$CardId));
				if(in_array($CardName,$already)){
					$this->session->set_flashdata('error',' Name Is Exist Choose Different Name!!');
					redirect(base_url(ADMIN.'Product'));
				}
			/*Check duplicate End*/

			$CardSlug = $this->general->createslug($CardName);

			$data 	= array(
					'Title'			=>$Title,
					'CardName'		=>$CardName,
					'CardSlug'		=>$CardSlug,
					'Description'	=>$Description,
					'Overview'		=>$Overview,
					'PricingText'	=>$PricingText,
					'SizingText'	=>$SizingText,
					'Link'			=>$Link,
					'CId'			=>$CId,
					'SubCateId'		=>$SubCateId,
					"ImageAlt"		=>$ImageAlt
				);

			/*Image Uploading*/
			if ($_FILES['Image']['error'] == 0) {
	            $ext 	= $this->general->checkext('Image',ADMIN.'Product');
	            $result = $this->general->upload_file("Image",PRODUCTPATH, time().'_'.rand().'.'.$ext, "jpg|png|jpeg");
	            if (is_array($result)) {
	                $this ->session->set_flashdata("error", "Image Not Uploaded.!!!");
	                redirect(base_url(ADMIN.'Product'));
	            }
	            $this->load->library('imageupload');
	            $res = $this->imageupload->resize_image(PRODUCTPATH,$result, PRODUCTPATH.'Thumb/', '170', '242');
	            $data['Image'] = $result;
	            unlink(PRODUCTPATH.$OldImage);
	            unlink(PRODUCTPATH.'Thumb/'.$OldImage);
	        }
	        /*Image Uploading End*/

			$res = $this->common->update_record('tblcard',array('CardId'=>$CardId),$data);
			$this->session->set_flashdata('success','Product Updated Successfully');
			redirect(base_url(ADMIN.'Product'));
		} else {
			$this->session->set_flashdata('error','Please Fill The Data First!!'.validation_errors());
			redirect(base_url(ADMIN.'Product/add/'.md5($CardId)));
		}
	}
	/*View product details*/
	public function view($id = '')
	{
		$this->load->model(ADMIN.'Productmodel');
		$data['view'] = $this->Productmodel->getproduct(array('md5(td.CardId)'=>$id));
		
		if(empty($data['view'])){
			redirect(base_url(ADMIN.'Product'));
		}
		$data['product'] = $data['view'][0];
		$this->load->view(ADMIN.'view_product',$data);
	}

	/*Add product Image*/
	public function AddProductImage()
	{
		$CardId = $this->input->post('CardId');
		if($_FILES['ProductImages']['error'][0] != '0'){
			$this->session->set_flashdata('error','Select The File First');
			redirect(base_url(ADMIN.'Product/view/'.md5($CardId)));
		}
		$this->load->library('imageupload');
		$images 	= $this->imageupload->multipleimageupload('ProductImages', PRODUCTPATH.$CardId.'/', 'jpg|png|jpeg');
		if(count($images) > 0){
			$ins 	= array();
			$total 	= count($images);
			$failed = 0;
			foreach ($images as $image) {

				$size 	= getimagesize(PRODUCTPATH.$CardId.'/'.$image['ImagePath']);
				$ins 	= array('ImagePath'=>$image['ImagePath'],'CardId'=>$CardId);
				$this->common->insert_record('tblimages',$ins);
			}
			$this->session->set_flashdata('success','Images Uploaded Successfully');
			redirect(base_url(ADMIN.'Product/view/'.md5($CardId)));
			
		} else {
			$this->session->set_flashdata('error','Some Thing Went Wrong!!');
			redirect(base_url(ADMIN.'Product/view/'.md5($CardId)));
		}
	}

	/*Delete Product Image*/
	public function DeleteImage($id = '')
	{
		if($id != ''){
			$img 		= $this->common->get_one_row('tblimages',array('md5(ImageId)'=>$id)); 
			$path 		= $img['ImagePath'];
			$cardid 	= $img['CardId'];
			$this->common->delete_record_from_db('tblimages',array('md5(ImageId)'=>$id));
			unlink(PRODUCTPATH.$cardid.'/'.$path);
			unlink(PRODUCTPATH.$cardid.'/Thumb/'.$path);
			$this->session->set_flashdata('success','Images Deleted Successfully!');
			redirect(base_url(ADMIN.'Product/view/'.md5($cardid)));

		} else {
			$delete = $this->input->post('Delete');
			$cardid = $this->input->post('cardid');
			
			if(count($delete) > 0){
				$total = 0;
				foreach ($delete as $del_id) {

					$img 	= $this->common->get_one_row('tblimages',array('ImageId'=>$del_id)); 
					$path 	= $img['ImagePath'];
					$res 	= $this->common->delete_record_from_db('tblimages',array('ImageId'=>$del_id));
					if($res >0){
						unlink(PRODUCTPATH.$cardid.'/'.$path);
						unlink(PRODUCTPATH.$cardid.'/Thumb/'.$path);
						$total++;
					}
				}
				if($total > 0){
					$this->session->set_flashdata('success',$total.' Images Deleted Successfully!');
					redirect(base_url(ADMIN.'Product/view/'.md5($cardid)));	
				} else {
					$this->session->set_flashdata('error','No Images Deleted!!');
					redirect(base_url(ADMIN.'Product/view/'.md5($cardid)));
				}
			} else {
				$this->session->set_flashdata('error','Input Not Specified!!');
				redirect(base_url(ADMIN.'Product/view/'.md5($cardid)));
			}
		}
	}

	/*For Delete The Record*/
	public function DeleteProduct($data='')
	{
		$arr 		= explode(",",base64_decode($data));
		$id 		= $arr[0];
		$table 		= $arr[1];
		$columnname = $arr[2];
		$controller = $arr[3];
		$crd 		= $this->common->get_all_record('tblcard',array('CardId'=>$id));
		
		if(count($crd) > 0){
			if($crd[0]['Image'] != '')
				unlink(PRODUCTPATH.$crd[0]['Image']);
				$deleteimage = $this->common->get_all_record('tblimages',array('CardId'=>$crd[0]['CardId']));

			/*Image check */
			if(count($deleteimage) > 0){
				foreach ($deleteimage as $del_id) {
					$path = $del_id['ImagePath'];
					$res = $this->common->delete_record_from_db('tblimages',array('ImageId'=>$del_id['ImageId']));
					if($res >0){
						unlink(PRODUCTPATH.$crd[0]['CardId'].'/'.$path);
						unlink(PRODUCTPATH.$crd[0]['CardId'].'/Thumb/'.$path);	
					}
				}
				rmdir(PRODUCTPATH.$crd[0]['CardId'].'/Thumb');
				rmdir(PRODUCTPATH.$crd[0]['CardId']);
			}
			/*Image check End*/
		}
		$aff_row = $this->common->delete_record_from_db($table,array($columnname=> $id ));
		$this->general->processandredirect($aff_row,'Product Deleted Successfully','Product Not Deleted !!!',$controller);
	}

	/*Fetcch Subcategory*/
	public function getsubcategory()
	{
		$cateid 	= $this->input->post('cateid');
		$res 		= $this->common->get_all_record('tblsubcategory',array('MainCateId'=>$cateid));
		$data 		= array();
		if(count($res) > 0){
			$option 	= '<option value="">Select Sub Category</option>';
			foreach ($res as $value) {
				$option .= '<option value="'.$value['CateId'].'">'.$value['Name'].'</option>';
			}
			$data['status'] 		= true;
			$data['Description'] 	= $option;
		} else {
			$data['status'] 		= false;
		}
		echo json_encode($data); exit;
	}
}
