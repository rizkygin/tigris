<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class email_template{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function email_notification($to,$autoreply_code,$message)
	{
		$this->CI->load->library('email');

		$check_email_config = $this->CI->general_model->datagrab(array(
															'tabel'=>array('ht_email_template t'=>'',
																			'ht_email_setting s'=>'s.email=t.email_reply'),
															'select'=>'	t.header,
																		t.mail_subject,
																		t.autoreply_code,
																		s.email,
																		s.username,
																		s.password,
																		s.protocol,
																		s.smtp_host,
																		s.smtp_port,
																		s.mail_type,
																		s.charset',
															'where'=>array('t.autoreply_code'=>$autoreply_code)
															));

		$config = Array(
		   'protocol'  	=> $check_email_config->row('protocol'),
		   'smtp_host'    => $check_email_config->row('smtp_host'),
		   'smtp_port'    => $check_email_config->row('smtp_port'),
		   'smtp_email'    => $check_email_config->row('email'),
		   'smtp_user'    => $check_email_config->row('username'),
		   'smtp_pass'    => $check_email_config->row('password'),
		   'mailtype'     => $check_email_config->row('mail_type'),
		   'charset'      => $check_email_config->row('charset'),
		);
		$email = $check_email_config->row('email');


		$this->CI->email->initialize($config);
 		$this->CI->email->set_newline("\r\n");
		//$this->email->crlf = "\n";
		$this->CI->email->from($email,$check_email_config->row('header'));
		$this->CI->email->to($to);
		 
		$this->CI->email->subject($check_email_config->row('mail_subject'));
		$this->CI->email->message($message);
		 
		$send_email = $this->CI->email->send();

		if($send_email)
		{
			return TRUE;
		}
		else
		{
			return FALSE;			
		}
	}


	public function createToken($token_code,$token_type,$id_pengguna)
	{
		$check_token = $this->CI->db->query(
				"select * from ht_req_token where token_type='$token_type' and id_pengguna='$id_pengguna' and token_status=0 order by id_token desc limit 1"
			);
		if($check_token->num_rows()>0)
		{
			$token_expired = $check_token->row('token_expired');
			if(strtotime($token_expired) <= strtotime(date('Y-m-d H:i:s')))
			{
				$token_req_date = date('Y-m-d H:i:s');
				$token_expired = date('Y-m-d H:i:s',strtotime('+48 Hour '.$token_req_date));
				$token_type = $token_type;
				$token_status = 0;
				$id_pengguna = $id_pengguna;
				$query_token = $this->CI->db->query(
						"insert 
							into ht_req_token 
						(token_type,token_code,token_expired,token_req_date,token_status,id_pengguna) 
							values 
						('$token_type','$token_code','$token_expired','$token_req_date','$token_status','$id_pengguna') "
					);
				return array(
						'token_code'=>$token_code,
						'token_req_date'=>$token_req_date,
						'token_expired'=>$token_expired
					);
			}
			else
			{
				$old_token_code = $check_token->row('token_code');
				$token_req_date = date('Y-m-d H:i:s');
				$token_expired = date('Y-m-d H:i:s',strtotime('+48 Hour '.$token_req_date));
				$query_token = $this->CI->db->query(
						"
						update 
							ht_req_token 
						set 
							token_expired='$token_expired',
							token_req_date='$token_req_date'
						where 
							id_pengguna='$id_pengguna' and token_type='$token_type' and token_code='$old_token_code'
						"
					);
				return array(
						'token_code'=>$check_token->row('token_code'),
						'token_req_date'=>$token_req_date,
						'token_expired'=>$token_expired
					);
			}
		}
		else
		{
			$token_req_date = date('Y-m-d H:i:s');
			$token_expired = date('Y-m-d H:i:s',strtotime('+48 Hour '.$token_req_date));
			$token_type = $token_type;
			$token_status = 0;
			$id_pengguna = $id_pengguna;
			$query_token = $this->CI->db->query(
					"insert 
						into ht_req_token 
					(token_type,token_code,token_expired,token_req_date,token_status,id_pengguna) 
						values 
					('$token_type','$token_code','$token_expired','$token_req_date','$token_status','$id_pengguna') "
				);
			return array(
					'token_code'=>$token_code,
					'token_req_date'=>$token_req_date,
					'token_expired'=>$token_expired
				);
		}
	}	

	public function checkToken($token_type)
	{
		if($this->CI->input->get('token_code'))
		{
			$token_code = $this->CI->input->get('token_code');
			$check_token_db = $this->CI->general_model->datagrab(array('tabel'=>'ht_req_token','where'=>array('token_code'=>$token_code,'token_status !='=>1)))->row();
			if($check_token_db)
			{
				$token_expired = $check_token_db->token_expired;
				if($token_expired > date('Y-m-d H:i:s'))
				{
					$status = TRUE;
					$return_data = $check_token_db;
					$error_message = null;
				}
				else
				{
					$status = FALSE;
					$return_data = null;
					$error_message = "token Kadaluarsa";
				}
			}
			else
			{
				$status = FALSE;
				$return_data = null;
				$error_message = "Code token tidak sesuai";
			}
		}
		else
		{
			$status = FALSE;
			$return_data = null;
			$error_message = "Link Token Salah";
		}

		return array(
				'status'=>$status,
				'return_data'=>$return_data,
				'error_message'=>$error_message,
			);
	}

}