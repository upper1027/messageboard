<?php declare(strict_types=1);

namespace App\Http\Controller;

use Swoft\Redis\Redis;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use App\Model\Entity\MessageBoard;
use App\Model\Entity\User;

/**
 * Class IndexController
 * @Controller()
 */
class IndexController
{
    /**
     * @RequestMapping("/tokenChecking")
     */
    public function tokenChecking()
    {

        $request = Context::mustGet()->getRequest();
        $headers = $request->getHeaders();

        if (!isset($headers['token'])||$headers['token'][0] == "null") {
            return ["error" => 1, "msg" => "token is no exist",];
        } else {
            $token = explode(".", $headers["token"][0]);
            $payload = json_decode(base64_decode($token[1]),true);
            $tokenCheck = $token[0].".".$token[1];
            $tokenCheck = $tokenCheck.".".hash_hmac("sha256", $tokenCheck, "ckx1027471200");
            if ($tokenCheck != $headers["token"][0]) {
                return ["error" => 2, "msg" => "token验证失败",];
            } elseif (time() > $payload['len'] + $payload['time']) {
                return ["error" => 3, "msg" => "token已过期,请重新登陆",];
            } else {
                return ["error" => 0, "msg" => "token验证成功", "data" => $payload];
            }
        }

    }
    /**
     * @RequestMapping("/")
     */
    public function index()
    {

        $message = MessageBoard::get();
        $data = [];
        foreach ($message as $mess) {
            $data[] = [
                "id" => $mess->getId(),
                "userId" => $mess->getUserId(),
                "userName" => $mess->getUserName(),
                "content" => $mess->getContent(),
                "addTime" => $mess->getAddTime(),

            ];
        }
        return view("index/index", $data);
    }

    /**
     * @RequestMapping("/login")
     */
    public function login()
    {
        return view("index/login");

    }

    /**
     * @RequestMapping("/loginChecking")
     */
    public function loginChecking()
    {
        $request = Context::mustGet()->getRequest();
        $data = $request->post();
        $user = User::where("user_name", $data['name'])->where("password",$data["password"])->first();

        if (empty($user)) {
            return ["status" => 0];
        } else {
            $type = [
                "typ" => "jwt",
                "alg" => "HS256",
            ];
            $payload = [
                "id" => $user->getId(),
                "name" => $data['name'],
                "time" => time(),
                "len" => 10*60*60,
            ];
            $token = base64_encode(json_encode($type)).".".base64_encode(json_encode($payload));
            $token = $token.".".hash_hmac("sha256", $token, "ckx1027471200");
            return ["status" => 200, "token" => $token];
        }
    }
    /**
     * @RequestMapping("/addContent")
     */
    public function addContent()
    {
        $request = Context::mustGet()->getRequest();
        $data = $request->post();
        $mess = MessageBoard::new();
        $mess->setUserId($data['id']);
        $mess->setUserName($data['name']);
        $mess->setContent($data['content']);
        $mess->setAddTime(date("Y-m-d H:i:s"));
        $flag = $mess->save();
        if ($flag) {
            return ["error" => "0"];
        } else {
            return ["error" => "1"];
        }
    }

    /**
     * @RequestMapping("/deleContent")
     */
    public function deleContent()
    {
        $request = Context::mustGet()->getRequest();
        $data = $request->get();
        $mess = MessageBoard::find($data['id']);
        $result = $mess->delete();
        $response = Context::mustGet()->getResponse();
        return $response->redirect("/",302);

    }


}
