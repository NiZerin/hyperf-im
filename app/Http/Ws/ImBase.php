<?php


namespace App\Http\Ws;


class ImBase
{
    const BUSINESS_SUCCESS_CODE = 200;
    const BUSINESS_CLIENT_BAD_VERSION_CODE = 201; // 客户端版本不对，需升级sdk
    const BUSINESS_FORBIDDEN_CODE = 301; // 被封禁
    const BUSINESS_USERNAME_OR_PASSWD_ERROR_CODE = 302; // 用户名或密码错误
    const BUSINESS_IP_LIMIT_CODE = 315; // IP限制
    const BUSINESS_NOT_PERMITTED_CODE = 403; // 非法操作或没有权限
    const BUSINESS_NOT_EXIST_CODE = 404; // 对象不存在
    const BUSINESS_ARG_TOO_LONG_CODE = 405; // 参数长度过长
    const BUSINESS_READ_ONLY_CODE = 406; // 对象只读
    const BUSINESS_CLIENT_TIMEOUT_CODE = 408; // 客户端请求超时
    const BUSINESS_SMS_VERIFY_FAILED_CODE = 413; // 验证失败(短信服务)
    const BUSINESS_ARG_NOT_CORRECT_CODE = 414; // 参数错误
    const BUSINESS_CLIENT_NETWORK_ERROR_CODE = 415; // 客户端网络问题
    const BUSINESS_RATE_CONTROL_CODE = 416; // 频率控制
    const BUSINESS_DUPLICATE_OPERATION_CODE = 417; // 重复操作
    const BUSINESS_CHANNEL_NOT_AVAILABLE_CODE = 418; // 通道不可用(短信服务)
    const BUSINESS_NUM_EXCEED_LIMIT_CODE = 419; // 数量超过上限
    const BUSINESS_ACCOUNT_BANNED_CODE = 422; // 账号被禁用
    const BUSINESS_ACCOUNT_CHAT_NOT_PERMITTED_CODE = 423; // 帐号被禁言
    const BUSINESS_HTTP_REQUEST_DUPLICATE_CODE = 431; // HTTP重复请求
    const BUSINESS_SERVER_INNER_ERROR_CODE = 500; // 服务器内部错误
    const BUSINESS_SERVER_TOO_BUSY_CODE = 503; // 服务器繁忙
    const BUSINESS_RECALL_MSG_TIMEOUT_CODE = 508; // 消息撤回时间超限
    const BUSINESS_BAD_PROTOCOL_CODE = 509; // 无效协议
    const BUSINESS_SERVICE_NOT_AVAILABLE_CODE = 514; // 服务不可用
    const BUSINESS_UNPACK_ERROR_CODE = 998; // 解包错误
    const BUSINESS_PACK_ERROR_CODE = 999; // 打包错误


    public static function error(string $msg, int $status_code) :string
    {
        $errorData = [
            'msg' => $msg,
            'error_code' => $status_code,
        ];
        return json_encode($errorData, 256);
    }

    public static function success(string $msg, int $status_code, array $data = null) :string
    {
        $succeedData = [
            'msg' => $msg,
            'success_code' => $status_code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }

    public static function json(string $msg, int $status_code, array $data = null) :string
    {
        $succeedData = [
            'msg' => $msg,
            'code' => $status_code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }

}