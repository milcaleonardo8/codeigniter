<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	//load data
	public function index()
	{
		$this->general->adminauth();
		$data['categories'] = $this->common->get_all_record('tblcategory');
		$this->load->view(ADMIN.'category_view',$data);
	}
	//For add /edit category
	public function add($id = '')
	{	
		$this->general->adminauth();
		if($id != '')
			$data['opr'] 	= 'Edit';
		else
			$data['opr'] 	= 'Add';
		$data['edit'] 		= $this->common->get_one_row('tblcategory',array('md5(CateId)'=>$id));
		if(empty($data['edit']) && $id != ''){
			redirect(base_url(ADMIN.'Category'));
		}
		$this->load->view(ADMIN.'add_category',$data);
	}
	//For Submit data for Add category process
	public function saveprocess()
	{
		$Name 					= $this->input->post('Name');
		$Title1 				= $this->input->post('Title1');
		$DescriptionTitle1 		= $this->input->post('DescriptionTitle1');
		$DescriptionTitle2 		= $this->input->post('DescriptionTitle2');
		$TestimonialBy 			= $this->input->post('TestimonialBy');
		$TestimonialText 		= $this->input->post('TestimonialText');
		
		$MetaTitle 				= $this->input->post('MetaTitle');
		$MetaKeywords 			= $this->input->post('MetaKeywords');
		$MetaDescription 		= $this->input->post('MetaDescription');

		$this->form_validation->set_rules('Name', 'Name', 'required');
		$this->form_validation->set_rules('Title1','Title 1','required');

		$this->form_validation->set_rules('MetaTitle','Meta Title','required');
		$this->form_validation->set_rules('MetaKeywords','Meta Keywords','required');
		$this->form_validation->set_rules('MetaDescription','Meta Description','required');

		if ($this->form_validation->run() == TRUE){
			/*Check dupliacte*/
			$already = $this->common->prepare_array_from_table('tblcategory','Name');
			if(in_array($Name,$already)){
				$this->session->set_flashdata('error',' Name Is Exist Choose Different Name!!');
				redirect(base_url(ADMIN.'Category'));
			}
			/*Check duplicate End*/

			$Slug = $this->general->createslug($Name);

			$data = array(
					'Name'				=>	$Name,
					'Slug'				=>	$Slug,
					'Title1'			=>	$Title1,
					'DescriptionTitle1' =>	$DescriptionTitle1,
					'DescriptionTitle2' =>	$DescriptionTitle2,
					'TestimonialBy'		=>	$TestimonialBy,
					'TestimonialText'	=>	$TestimonialText,
					'MetaTitle'			=>	$MetaTitle,
					'MetaKeywords'		=>	$MetaKeywords,
					'MetaDescription'	=>	$MetaDescription
				);

			/*For Image Uploading*/
			if ($_FILES['Image1']['error'] == 0) {
	            $ext 		= $this->general->checkext('Image1',ADMIN.'Category');
	            $result 	= $this->general->upload_file("Image1",CATEIMAGE, time().'_'.rand().'.'.$ext, "jpg|png|jpeg");

	            if (is_array($result)) {
	                $this ->session->set_flashdata("error", "Image Not Uploaded.!!!");
	                redirect(base_url(ADMIN.'Category'));
	            }

	            //350 * 244
	            $this->load->library('imageupload');
	            $res 			= $this->imageupload->resize_image(CATEIMAGE,$result, CATEIMAGE.'Thumb/', '100', '60');
	            $data['Image1'] = $result;
	        }
	        /*For Image Uploading End*/

			$res = $this->common->insert_record('tblcategory',$data);
			$this->general->processandredirect($res,'Category Added Successfully','Category Not Added',ADMIN.'Category');
		} else {
			$this->session->set_flashdata('error','Please Fill The Data First!!'.validation_errors());
			redirect(base_url(ADMIN.'Category/add'));
		}
	}
	//For Submit data for Edit category process
	public function editprocess()
	{
		$CateId 			= $this->input->post('CateId');
		$OldImage1 			= $this->input->post('OldImage1');
		$Name 				= $this->input->post('Name');
		$Title1 			= $this->input->post('Title1');
		$DescriptionTitle1 	= $this->input->post('DescriptionTitle1');
		$DescriptionTitle2 	= $this->input->post('DescriptionTitle2');
		$TestimonialBy 		= $this->input->post('TestimonialBy');
		$TestimonialText 	= $this->input->post('TestimonialText');

		$MetaTitle 			= $this->input->post('MetaTitle');
		$MetaKeywords 		= $this->input->post('MetaKeywords');
		$MetaDescription 	= $this->input->post('MetaDescription');

		$this->form_validation->set_rules('Name', 'Name', 'required');
		$this->form_validation->set_rules('Title1','Title 1','required');
		$this->form_validation->set_rules('DescriptionTitle1','DescriptionTitle 1 ','required');

		$this->form_validation->set_rules('MetaTitle','Meta Title','required');
		$this->form_validation->set_rules('MetaKeywords','Meta Keywords','required');
		$this->form_validation->set_rules('MetaDescription','Meta Description','required');
		
		if ($this->form_validation->run() == TRUE){
			$already 	= $this->common->prepare_array_from_table('tblcategory','Name',array('CateId !='=>$CateId));

			/*Check duplicate*/
			if(in_array($Name,$already)){
				$this->session->set_flashdata('error',' Name Is Exist Choose Different Name!!');
				redirect(base_url(ADMIN.'Category'));
			}
			/*Check duplicate End*/
			$Slug = $this->general->createslug($Name);

			$data = array(
					'Name'					=>$Name,
					'Slug'					=>$Slug,
					'Title1'				=>$Title1,
					'DescriptionTitle1'		=>$DescriptionTitle1,
					'DescriptionTitle2'		=>$DescriptionTitle2,
					'TestimonialBy'			=>$TestimonialBy,
					'TestimonialText'		=>$TestimonialText,
					'MetaTitle'				=>$MetaTitle,
					'MetaKeywords'			=>$MetaKeywords,
					'MetaDescription'		=>$MetaDescription
				);

			/*For Image Uploading*/
			if ($_FILES['Image1']['error'] == 0) {
	            $ext 	= $this->general->checkext('Image1',ADMIN.'Category');
	            $result = $this->general->upload_file("Image1",CATEIMAGE, time().'_'.rand().'.'.$ext, "jpg|png|jpeg");

	            if (is_array($result)) {
	                $this ->session->set_flashdata("error", "Image Not Uploaded.!!!");
	                redirect(base_url(ADMIN.'Category'));
	            }

	            $this->load->library('imageupload');
	            $res 	= $this->imageupload->resize_image(CATEIMAGE,$result, CATEIMAGE.'Thumb/', '100', '60');
	            $data['Image1'] = $result;
	            unlink(CATEIMAGE.$OldImage1);
	            unlink(CATEIMAGE.'Thumb/'.$OldImage1);
	        }
	        /*For Image Uploading End*/

			$res 	= $this->common->update_record('tblcategory',array('CateId'=>$CateId),$data);
			$this->general->processandredirect($res,'Category Updated Successfully','Category Not Updated',ADMIN.'Category');
		} else {
			$this->session->set_flashdata('error','Please Fill The Data First!!'.validation_errors());
			redirect(base_url(ADMIN.'Category/add/'.md5($CateId)));
		}
	}
	//For Delete The Record
	public function DeleteRecord($data='')
	{
		$arr 		= explode(",",base64_decode($data));
		$id 		= $arr[0];
		$table 		= $arr[1];
		$columnname = $arr[2];
		$controller = $arr[3];
		$record 	= $this->common->get_all_record('tblcategory',array('CateId'=>$id));
		$aff_row 	= $this->common->delete_record_from_db($table,array($columnname=> $id ));

		if($aff_row > 0){
			if($record[0]['Image1'] != '')
				unlink(CATEIMAGE.$record[0]['Image1']);

			/*  Sub category */
			$subc = $this->common->get_all_record('tblsubcategory',array('MainCateId'=>$id));
			if(count($subc) > 0){
				
				foreach ($subc as $key => $subcid) {
					if($subcid['Image1'] != '')
						unlink(CATEIMAGE.$subcid['Image1']);
					if($subcid['Image2'] != '')
						unlink(CATEIMAGE.$subcid['Image2']);
					$flip = $this->common->get_all_record('tblflipimages',array('SubCateId'=>$subcid['CateId']));
					foreach ($flip as $f) {
						$res = $this->common->delete_record_from_db('tblflipimages',array('ImageId'=>$f['ImageId']));
						if($res >0){
							unlink(FLIPPATH.$subcid['CateId'].'/'.$f['ImagePath']);
							unlink(FLIPPATH.$subcid['CateId'].'/Thumb/'.$f['ImagePath']);
						}
					}
					$crd = $this->common->get_all_record('tblcard',array('SubCateId'=>$subcid['CateId']));
					if(count($crd) > 0){
						foreach ($crd as $c) {
							if($c['Image'] != '')
								unlink(PRODUCTPATH.$c['Image']);
							$deleteimage = $this->common->get_all_record('tblimages',array('CardId'=>$c['CardId']));
							if(count($deleteimage) > 0){
								foreach ($deleteimage as $del_id) {
									$path = $del_id['ImagePath'];
									$res = $this->common->delete_record_from_db('tblimages',array('ImageId'=>$del_id['ImageId']));
									if($res >0){
										unlink(PRODUCTPATH.$c['CardId'].'/'.$path);
										unlink(PRODUCTPATH.$c['CardId'].'/Thumb/'.$path);
									}
								}
								rmdir(PRODUCTPATH.$c['CardId'].'/Thumb');
								rmdir(PRODUCTPATH.$c['CardId']);
							}//Image check
						}//Card Loop
					}
					$aff_row	 = $this->common->delete_record_from_db('tblsubcategory',array('CateId'=> $subcid['CateId'] ));
					$section 	= $this->common->delete_record_from_db('tblsection',array('CateId'=> $subcid['CateId'] ));
					$cards 		= $this->common->delete_record_from_db('tblcard',array('SubCateId'=>$subcid['CateId']));
					$service 	= $this->common->delete_record_from_db('tblservice',array('SubCateId'=> $subcid['CateId'] ));
					$price 		= $this->common->delete_record_from_db('tblprice',array('SubCateId'=> $subcid['CateId'] ));
				}
			}
			/*End Sub Category*/

			/*Card */
			$crd = array();
			$crd = $this->common->get_all_record('tblcard',array('CId'=>$id));
			if(count($crd) > 0){
				foreach ($crd as $c) {
					if($c['Image'] != '')
						unlink(PRODUCTPATH.$c['Image']);
					$deleteimage = $this->common->get_all_record('tblimages',array('CardId'=>$c['CardId']));
					if(count($deleteimage) > 0){
						foreach ($deleteimage as $del_id) {
							$path = $del_id['ImagePath'];
							$res = $this->common->delete_record_from_db('tblimages',array('ImageId'=>$del_id['ImageId']));
							if($res >0){
								unlink(PRODUCTPATH.$c['CardId'].'/'.$path);
								unlink(PRODUCTPATH.$c['CardId'].'/Thumb/'.$path);
							}
						}
						rmdir(PRODUCTPATH.$c['CardId'].'/Thumb');
						rmdir(PRODUCTPATH.$c['CardId']);
					}//Image check
				}
				//Card Loop End
			}
			/*Card End*/

			$cards 		= $this->common->delete_record_from_db('tblcard',array('CId'=>$id));
			$section 	= $this->common->delete_record_from_db('tblsection',array('CateId'=> $id ));
			$service 	= $this->common->delete_record_from_db('tblservice',array('CateId'=> $id ));
			$price 		= $this->common->delete_record_from_db('tblprice',array('CategoryId'=> $id ));
		}
		$this->general->processandredirect($aff_row,'Category Deleted Successfully','Category Not Deleted !!!',$controller);
	}
	//For Get The Full Description Of Category
	public function GetDesc()
	{
		$id 		= $this->input->post('id');
		$result 	= $this->common->get_all_record('tblcategory',array('CateId'=>$id));
		$return 	= array();
		if(count($result) > 0){
			$res 	 = '<div class="row">';
			$res 	.= '<div class="col-md-12"><table class="table table-responsive table-striped detail"><tr><td><label>Name</label></td><td>'.$result[0]['Name'].'</td>
	            </tr></table></div>';
			$res 	.= '<div class="col-md-12">';
			$res 	.= '<table class="table table-responsive table-striped detail">';
            $res 	.= '<tr><td><label>Title</label></td><td>'.$result[0]['Title1'].'</td></tr>';
            $res 	.= '<tr><td><label>Short Description</label></td><td>'.$result[0]['DescriptionTitle2'].'</td></tr>';
            $res 	.= '<tr><td><label>Description</label></td><td><p>'.$result[0]['DescriptionTitle1'].'</p></td></tr>';

            if($result[0]['TestimonialBy'] == ''){
            	$res .= '<tr><td><label>Testimonial</label></td><td><p>Testimonial Not Added</p></td></tr>';
            } else {
	            $res .= '<tr><td><label>Testimonial</label></td><td><p>'.$result[0]['TestimonialText'].'<span class="pull-right">- <b>'.$result[0]['TestimonialBy'].'</b></span></p></td></tr>';
	        }

            $res 	.= '<tr><td><label>Image</label></td><td><img src="'.base_url(CATEIMAGE.$result[0]['Image1']).'" alt="No Image Avalilable" class="img img-responsive" style="max-height: 200px; max-width: 300px;"></td></tr>';
        	$res 	.= '</table>';
			$res 	.= '</div>';
        	$res 	.= '</div>';

			$return['status'] = true;
			$return['result'] = $res;
		} else {
			$return['status'] = false;
		}
		echo json_encode($return); exit;
	}
}
